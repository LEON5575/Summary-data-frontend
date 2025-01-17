const express = require('express');
const http = require('http');
const { Server } = require('socket.io');
const { MongoClient } = require('mongodb');

const app = express();
const server = http.createServer(app);
const io = new Server(server, {
    cors: {
        origin: '*', // Allow all origins (adjust as needed)
        methods: ['GET', 'POST']
    }
});

// MongoDB connection URI
const uri = 'mongodb://localhost:27017/chatApp'; 
const client = new MongoClient(uri);
let db;

client.connect()
    .then(() => {
        console.log("Connected to MongoDB");
        db = client.db('ChatApp');
    })
    .catch(err => console.error("Failed to connect to MongoDB", err));

// Handle socket connections
io.on('connection', (socket) => {
    console.log('A user connected');

    socket.on("code", async (data) => {
        console.log("Received data:", data);

        const { sender, receiver, message } = data;

        if (!sender || !receiver || !message) {
            console.error("Invalid data received:", data);
            return;
        }

        const chat = {
            sender,
            receiver,
            message,
            timestamp: new Date()
        };

        try {
            const result = await db.collection('chatData').insertOne(chat);
            console.log("Message inserted:", result.insertedId);
            io.emit("message", {
                sender: chat.sender,
                message: chat.message,
                receiver: chat.receiver,
                timestamp: chat.timestamp
            });
        } catch (err) {
            console.error("Failed to insert message:", err);
        }
    });

    // Handle disconnection
    socket.on('disconnect', () => {
        console.log ('A user disconnected');
    });
});

// Start the server
server.listen(3000, () => {
    console.log("Server started at port 3000");
});