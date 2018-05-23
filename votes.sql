USE suggestotron;

CREATE TABLE votes ( 
    id INT unsigned NOT NULL AUTO_INCREMENT, 
    topic_id INT unsigned NOT NULL, 
    count INT NOT NULL DEFAULT 0, 
    PRIMARY KEY(id) 
);

INSERT INTO votes (
    topic_id,
    count,
    count_down
) SELECT id, 0 FROM topics;