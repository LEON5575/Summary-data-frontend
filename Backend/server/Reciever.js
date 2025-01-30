const Bull = require('bull');
const { MongoClient } = require("mongodb");

const mongoUri = "mongodb://127.0.0.1:27017/chatApp";
const dbName = "chat";
let db, usersCollection, messagesCollection;

async function connectMongo() {
    try {
        const client = await MongoClient.connect(mongoUri);
        db = client.db(dbName);
        //usersCollection = db.collection("users");
        messagesCollection = db.collection("messages");
        console.log("Connected to MongoDB");
    } catch (err) {
        console.error("MongoDB connection error:", err);
        process.exit(1);
    }
}

connectMongo();

//redis connection
const myFirstQueue = new Bull('bullExample', { 
    redis: { 
        port: 6379, 
        host: '192.168.0.94' 
    } 
});

myFirstQueue.process(async (job, done ) => {
    await db.collection("messages").insertOne(job.data);
    console.log("Data", job.data );
    done();
});

myFirstQueue.on('completed', job => {
    console.log(`Job with id ${job.id} has been completed`);
    job.remove();
})

module.exports = myFirstQueue;