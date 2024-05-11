-- Insert data into the users table
INSERT INTO users (username, email, password) VALUES
('user1', 'user1@example.com', 'password1'),
('user2', 'user2@example.com', 'password2'),
('user3', 'user3@example.com', 'password3'),
('user4', 'user4@example.com', 'password4'),
('user5', 'user5@example.com', 'password5');

-- Insert data into the messages table
INSERT INTO messages (sender_id, recipient_id, message) VALUES
(1, 2, 'Hello user2!'),
(2, 1, 'Hello user1!'),
(1, 3, 'Hello user3!'),
(3, 1, 'Hello user1!'),
(1, 4, 'Hello user4!'),
(4, 1, 'Hello user1!'),
(1, 5, 'Hello user5!'),
(5, 1, 'Hello user1!');

-- Insert data into the relationships table
INSERT INTO relationships (user1_id, user2_id, status) VALUES
(1, 2, 'accepted'),
(1, 3, 'pending'),
(1, 4, 'accepted'),
(1, 5, 'pending'),
(2, 3, 'accepted'),
(2, 4, 'pending'),
(2, 5, 'accepted'),
(3, 4, 'pending'),
(3, 5, 'accepted'),
(4, 5, 'pending');