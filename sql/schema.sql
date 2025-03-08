CREATE TABLE page (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT,
    content TEXT
);

INSERT INTO page (title, content) VALUES ('Welcome', 'Welcome to our awesome web app!');
INSERT INTO page (title, content) VALUES ('About', 'This is an example page.');
INSERT INTO page (title, content) VALUES ('Contact', 'Contact us at example@example.com');
