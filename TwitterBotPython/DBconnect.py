import mysql.connector
from mysql.connector import Error


def dbCon():
    try:
        connection = mysql.connector.connect(host='remotemysql.com',
                                            database='8hwqgMaYLb',
                                            user='8hwqgMaYLb',
                                            password='B3bHSPBS9o')
        if connection.is_connected():
            db_Info = connection.get_server_info()
            # print("Connected to MySQL Server version ", db_Info)
            cursor = connection.cursor()
            cursor.execute("select database();")
            record = cursor.fetchone()
            # print("You're connected to database: ", record[0])

            
    except Error as e:
        print("Error while connecting to MySQL", e)

    return connection

def dbQuery(conn,query):
    cursor = conn.cursor()
    cursor.execute(query)
    records = cursor.fetchall()

    print("Total number of rows in Laptop is: ", cursor.rowcount)

    return records

def dbClose(conn):
    cursor = conn.cursor()
    if (conn.is_connected()):
        cursor.close()
        conn.close()
        print("MySQL connection is closed")    
