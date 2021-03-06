# -*- coding: utf-8 -*-
'''
###########################################
#  Created on 2011-10-25
#  @author: cl.lam
#  Description:
###########################################
'''
from datetime import datetime as dt
from sqlalchemy import create_engine, Column, ForeignKey
from sqlalchemy.types import Integer, DateTime, Text, Unicode
from sqlalchemy.orm import scoped_session, sessionmaker, relation, backref, synonym
from sqlalchemy.ext.declarative import declarative_base


SQLALCHEMY_DATABASE_URI = "mysql://root:root@127.0.0.1:3306/car?charset=utf8"

engine = create_engine( SQLALCHEMY_DATABASE_URI, echo = False, pool_size = 20 )
maker = sessionmaker( bind = engine, autoflush = True, autocommit = False )
DBSession = scoped_session( maker )
DeclarativeBase = declarative_base()
metadata = DeclarativeBase.metadata

# DBSession.configure(bind = engine)

#===============================================================================
# model define
#===============================================================================

class SysMixin( object ):
    create_time = Column( DateTime, default = dt.now )
    create_by_id = Column( Integer, default = 1 )
    update_time = Column( DateTime, default = dt.now, onupdate = dt.now )
    update_by_id = Column( Integer, default = 1 )
    active = Column( Integer, default = 0 )  # 0 is active ,1 is inactive



class User( DeclarativeBase, SysMixin ):
    __tablename__ = 'thinkphp_user'

    id = Column( Integer, autoincrement = True, primary_key = True )
    name = Column( Unicode( 100 ), nullable = False )
    password = Column( Unicode( 100 ), nullable = False )
    email = Column( Unicode( 500 ) )





def init():
    print "drop all tables"
    metadata.drop_all( engine, checkfirst = True )
    print "create table"
    metadata.create_all( engine )
    print "insert default value"

    # default user
    DBSession.add( User( name = "admin", password = "password", email = "lamciuloeng@gmail.com" ) )
    DBSession.commit()
    print "Done"


if __name__ == "__main__":
    init()
