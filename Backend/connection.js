const { MongoClient, ServerApiVersion } = require("mongodb");

const url = "mongodb://127.0.0.1:27017/chatApp";

const client = new MongoClient(url, {
  serverApi: {
    version: ServerApiVersion.v1,
    strict: true,
    deprecationErrors: true,
  },
});

const databaseName = "chatApplication";

const connection = async () => {
  try {
    await client.connect();
    console.log("Connected successfully to MongoDB server");
    const db = client.db(databaseName);
    return db;
  } catch (error) {
    console.error("MongoDB connection error:", error);
  }
};
module.exports = connection;