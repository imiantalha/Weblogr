CREATE TABLE blogs (
    blog_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    created_date DATE NOT NULL,
    description TEXT,
    image VARCHAR(255),
    likes INT DEFAULT 0
);

ALTER TABLE blogs 
ADD COLUMN user_id INT,
ADD CONSTRAINT fk_user_id
    FOREIGN KEY (user_id) 
    REFERENCES users(user_id);


CREATE TABLE comments (
    comment_id INT AUTO_INCREMENT PRIMARY KEY,
    blog_id INT,
    commenter_id INT,
    comment_text TEXT,
    comment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (blog_id) REFERENCES blogs(blog_id),
    FOREIGN KEY (commenter_id) REFERENCES users(user_id)
);


ALTER TABLE blogs 
DROP CONSTRAINT fk_user_id;

