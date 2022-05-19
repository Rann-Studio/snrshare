import mysql.connector
import datetime
import time
import pytz
import os

nowTime = datetime.datetime.now(pytz.timezone('Asia/Jakarta')).strftime('%Y-%m-%d %H:%M:%S')

def checkExpired():
    db = mysql.connector.connect(
        host='localhost',
        user='root',
        passwd='',
        database='snrshare'
    )
    cursor = db.cursor()
    
    sql = "SELECT * FROM files WHERE expiretime < '" + nowTime + "'"
    cursor.execute(sql)
    result = cursor.fetchall()
    if len(result) > 0:
        for row in result:
            sql = "DELETE FROM files WHERE id = " + str(row[0])
            cursor.execute(sql)
            db.commit()
            os.remove("uploadFiles/" + row[2])
            print("File " + row[2] + " has been deleted")
    else:
        print("No file has been deleted")
    db.close()
    
while True:
    try:
        checkExpired()
        time.sleep(60 * 5) # sleep every 5 minutes
        
    except Exception as e:
        print(e)