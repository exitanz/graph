import sqlite3


class ConnectionManager:
    dbname = 'dkgraph_correlation.db'
    db = None

    def __init__(self):
        self.db = sqlite3.connect(self.dbname)

    def getDB(self):
        return self.db