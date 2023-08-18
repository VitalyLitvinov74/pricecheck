use pricecheck;
db.createUser(
    {
        user: "root",
        pwd: "root",
        roles: [
            {
                role: "readWrite",
                db: "pricecheck"
            }
        ]
    }
);