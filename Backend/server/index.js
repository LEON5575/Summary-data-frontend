const express = require("express");
const cors = require("cors");
const { createServer } = require("http");
const { Server } = require("socket.io");
const { MongoClient } = require("mongodb");
const bodyParser = require("body-parser");
const env = require('dotenv');
env.config();
const myFirstQueue = require('./Reciever')

const app = express();
app.use(
  cors({
    origin: "http://localhost:8080",
    credentials: true,
  })
);
app.use(bodyParser.json());

const uri = "mongodb://localhost:27017/chatApp";
const client = new MongoClient(uri);
let db;

async function connectToMongo() {
  try {
    await client.connect();
    db = client.db("chat");
    console.log("Connected to MongoDB");
  } catch (err) {
    console.error("Failed to connect to MongoDB", err);
  }
}

connectToMongo();

const server = createServer(app);
const io = new Server(server, {
  cors: {
    origin: '*',
    methods: ['GET', 'POST']
  }
});

io.on("connection", (socket) => {
    socket.on("username", (username) => {
      socket.username = username; // Store the username in the socket object
      console.log(`${username} connected`);
    });
  
    socket.on("joinRoom", async ({ receiver }) => {
      const sender = socket.username; // Get the sender from the socket object
      const room = [sender, receiver].sort().join("_");
      console.log(`${sender} joined room ${room}`);
      socket.join(room);
  
      try {
        const messages = await db
          .collection("messages")
          .find({
            $or: [
              { sender, receiver },
              { sender: receiver, receiver: sender },
            ],
          })
          .sort({ timestamp: 1 })
          .toArray();
        console.log(messages);
        socket.emit("previousMessages", messages);
      } catch (err) {
        console.error("Error fetching messages:", err);
      }
    });
  
    socket.on("send-message", async ({ sender, receiver, message }) => {
      try {
          const room = [sender, receiver].sort().join("_");
          const chat = {
              sender,
              receiver,
              message,
              timestamp: new Date(), 
          };
          console.log(chat);
          myFirstQueue.add(chat); 
          
          //   db.collection('messages').insertOne(chat); //& if redis server is closed then  use this line
          io.to(room).emit("new-message", chat); 
      } catch (err) {
          console.error("Failed to save/send message:", err);
      }
  });
  
    socket.on("disconnect", () => {
      console.log(`${socket.username} disconnected`);
    });
  });
const PORT = process.env.PORT || 3000; // Ensure a default port is set
server.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`);
});