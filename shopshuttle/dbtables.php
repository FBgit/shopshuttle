<?php


$kats = "CREATE TABLE IF NOT EXISTS bike_category( 
    cat_id   INT AUTO_INCREMENT,
    cat_num   INT(5),
    cat_name  VARCHAR(100) NOT NULL, 
    infotext VARCHAR(255) NULL, 
    PRIMARY KEY(cat_id)
  );";