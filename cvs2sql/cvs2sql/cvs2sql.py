import csv
import pymysql

# Connect to MySQL database
conn = pymysql.connect(host='localhost',
                       user='root', #update username
                       password='Password',  #update password
                       database='song_db',
                       charset='utf8mb4')
cursor = conn.cursor()

# Create a new table in the database
cursor.execute('''CREATE TABLE IF NOT EXISTS songs (
                    track_id VARCHAR(255) PRIMARY KEY,
                    title VARCHAR(255),
                    song_id VARCHAR(255),
                    release_date DATE,
                    artist_id VARCHAR(255),
                    artist_mbid VARCHAR(255),
                    artist_name VARCHAR(255),
                    duration_seconds INT,
                    artist_familiarity FLOAT,
                    artist_hotttnesss FLOAT,
                    year INT,
                    track_7digitalid INT,
                    shs_perf INT,
                    shs_work INT
                );''')

# Read CSV file and insert data into the table
with open(r'C:\Users\Caesar\Downloads\track_metadata.csv', newline='', encoding='utf-8') as csvfile: #Update output file location
    csvreader = csv.reader(csvfile)
    next(csvreader)  # Skip header row
    for row in csvreader:
        cursor.execute('''INSERT IGNORE INTO songs VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s);''', row)

# Commit changes
conn.commit()

# Close connection
conn.close()

# Print message when done
print("Data insertion into the 'songs' table is completed.")
