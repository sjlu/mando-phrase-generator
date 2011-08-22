<?php

  #############################################################################
  # Burst Development MySQL Object                                            #
  # Copyright (c) 2007 Burst Development, LLC                                 #
  #                                                                           #
  # This file is property of Burst Development, LLC.  You should not be       #
  # seeing this message unless you are a client of, or an employee of Burst   #
  # Development.                                                              #
  #                                                                           #
  # Defines a class for usage with a MySQL Database.                          #
  # Originally written by Russell Frank, 10 13 07.                            #
  #############################################################################

  class BurstMySQL {
    var $mConnection;
    var $mDBName;
    var $mQueries = array();
    var $mTotal=0;

    public function __construct ($mHost, $mUser, $mPass, $mDatabase, 
                                 $mPort=3306) {
      $this->mConnection = @mysql_connect($mHost . ':' . $mPort, $mUser, $mPass)
                                          or $this->OnError();
      $this->mDBName = $mDatabase;
      mysql_select_db ($mDatabase, $this->mConnection);
    }

    public function OnError () {
      echo ('<br><div style="border-style:solid; border-width: 1px;
             border-color: #ffd04d; background-color: #fff5b1; padding:10px">
             <div style="letter-spacing: 1px; font-family: verdana;
	     font-size: 20px; text-align: left; color: #003355">
	     MySQL Database Error </div>
	     <div style="font-family: verdana; font-size: 12px;
	     text-align: left;">' . mysql_error($this->mConnection) .
	     '</div></div>');
      die();
    }

    public function Delete ($mTable, $mWhere) {
      $this->mQueries[$this->mTotal] = 'DELETE FROM `' . $mTable . '` WHERE ' . $mWhere;
      $this->mTotal++;
    }

    public function ChangeDB ($mDatabase) {
      $this->mDBName = $mDatabase;
    }

    public function Update ($mTable, $mSet, $mWhere) {
      $this->mQueries[$this->mTotal] = 'UPDATE ' . $mTable .' SET ' . $mSet . ' WHERE ' . $mWhere;
      $this->mTotal++;
    }

    public function Select ($mTable, $mFields, $mWhere = 1, $mStart=0, $mTotal=100) {
      $mReturnData = array();
      $mWhere = stripslashes($mWhere);
      $mResult = @mysql_query ('SELECT ' . $mFields . ' FROM '
                               . $mTable . ' WHERE ' . $mWhere . ' LIMIT ' . 
			       $mStart . ' , ' . $mTotal, $this->mConnection) 
			       or $this->OnError();
      while ($row = @mysql_fetch_array($mResult, MYSQL_ASSOC)) {
        $mReturnData[] = $row;
      }
      return $mReturnData;
    }

    public function Insert ($mTable, $mFields, $mValues) {
      $this->mQueries[$this->mTotal] = 'INSERT INTO `' . $this->mDBName . '`.`' . $mTable .
                                 '` (' . $mFields . ') VALUES (' . $mValues . ');';
      $this->mTotal++;
    }

    public function Raw ($mQuery) {
      $mReturnData = array();
      $mResult = @mysql_query ($mQuery, $this->mConnection) or $this->OnError();
      while ($row = @mysql_fetch_array ($mResult, MYSQL_ASSOC))
        $mReturnData[] = $row;
      return $mReturnData;
    }

    public function __destruct () {
      foreach ($this->mQueries as $mQuery) {
        if (!@mysql_query ($mQuery, $this->mConnection))
	  $this->OnError();
      }
      @mysql_close ($this->mConnection);
    }

    public function GetTotal () {
      return $this->mTotal;
    }
  }

?>
