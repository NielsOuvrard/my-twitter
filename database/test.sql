-- Insert users
INSERT INTO users (username, email, password, is_admin)
VALUES 
('user1', 'user1@example.com', '$2y$10$c.q/ApOf0T2uqhP9KBBdU.YDyow91B.FadYxsTGi9nU2Sl7gAXV3W', false), -- password: password
('user2', 'user2@example.com', '$2y$10$c.q/ApOf0T2uqhP9KBBdU.YDyow91B.FadYxsTGi9nU2Sl7gAXV3W', false),
('admin', 'admin@example.com', '$2y$10$c.q/ApOf0T2uqhP9KBBdU.YDyow91B.FadYxsTGi9nU2Sl7gAXV3W', true);

-- Insert messages
INSERT INTO messages (sender_id, recipient_id, content)
VALUES 
(1, 2, 'Hello user2!'),
(2, 1, 'Hello user1!'),
(1, 3, 'Hello admin!');

-- Insert relationships
INSERT INTO relationships (user1_id, user2_id, status)
VALUES 
(1, 2, 'accepted'),
(2, 3, 'pending'),
(1, 3, 'accepted');

-- Insert publications
INSERT INTO publications (user_id, content)
VALUES 
(1, 'This is a post by user1'),
(2, 'This is a post by user2'),
(3, 'This is a post by the admin');