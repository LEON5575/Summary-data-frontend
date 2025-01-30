//~https://betterprogramming.pub/message-queue-using-bull-redis-and-mongodb-in-node-js-d7dedaa426ea
//& bull q in mongo

const bull = require('bull')
const { MongoClient } = require('mongodb');

let db, messagesCollection;

//mongo connection code
const url = "mongodb://127.0.0.1:27017/chatApp";
const client = new MongoClient(url);
const databaseName = "chat";

const connection = async () => {
  try {
    await client.connect();
    db = client.db(databaseName);
    messagesCollection = db.collection("messages");
    console.log("Connected successfully to MongoDB server");
  } catch (error) {
    console.error("MongoDB connection error:", error);
    throw error;
  }
};
connection();

const myFirstQueue = new bull('bullDemo', { 
    redis: { 
        port: 6379, 
        host: '192.168.0.94' 
    }
    })

myFirstQueue.process(async (job,done)=>{
    await db.collection("messages").insertOne(job.data);
    console.log("Data", job.data );
    done();
})

myFirstQueue.on('completed', job => {
    console.log(`Job with id ${job.id} has been completed`);
    job.remove();
})

module.exports = myFirstQueue;


