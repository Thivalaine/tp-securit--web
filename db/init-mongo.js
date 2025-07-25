db = db.getSiblingDB('tpsecu');
db.createUser({user: 'tpuser', pwd: 'tppass', roles: [{role: 'readWrite', db: 'tpsecu'}]});
db.users.insertOne({username: 'admin', password: 'adminpass'}); 