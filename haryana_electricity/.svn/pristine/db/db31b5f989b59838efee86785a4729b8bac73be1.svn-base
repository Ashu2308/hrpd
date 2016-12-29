package com.hrpdss.android.storage;

import android.content.Context;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;
/**
 * Created by Abhishek on 4/21/2016.
 */
public class DataStoreHandler extends SQLiteOpenHelper {

	public static final String COLUMN_ID = "_id";

	public static final String TABLE_LINEMAN_PENDINGLIST = "linemandata";
	public static final String TABLE_LINEMAN_CATEGORY = "linemancategorydata";
	public static final String COLUMN_LINEMAN_REPORTEDDATE = "reportdatedate";
	public static final String COLUMN_LINEMAN_RESOLVEDATE= "resolvedate";
	public static final String COLUMN_LINEMAN_CUST_NAME = "name";
	public static final String COLUMN_LINEMAN_CUST_MOB = "mobile";
	public static final String COLUMN_LINEMAN_CUST_ID = "cust_id";
	public static final String COLUMN_LINEMAN_COMP_ID = "comp_id";
	public static final String COLUMN_LINEMAN_CUST_ADD = "address";
	public static final String COLUMN_LINEMAN_CAT_ID = "cat_id";
	public static final String COLUMN_LINEMAN_CAT_NAME = "cat_name";

	public static final String[] allLINEMANPENDINGLISTColumns = { COLUMN_ID,
			COLUMN_LINEMAN_CUST_NAME, COLUMN_LINEMAN_CUST_ID,COLUMN_LINEMAN_COMP_ID,
			COLUMN_LINEMAN_CUST_MOB, COLUMN_LINEMAN_CUST_ADD,
			COLUMN_LINEMAN_REPORTEDDATE, COLUMN_LINEMAN_RESOLVEDATE };

	public static final String[] getallLINEMANCATEGORYColumns = { COLUMN_ID,
			COLUMN_LINEMAN_CAT_ID,
			COLUMN_LINEMAN_CAT_NAME, };

	// database info
	public static final String DATABASE_NAME = "lineman";
	private static final int DATABASE_VERSION = 1;

	private static final String DATABASE_CREATE_LINEMAN_PENDINGLIST_TBL = "CREATE TABLE IF NOT EXISTS "
			+ TABLE_LINEMAN_PENDINGLIST
			+ "("
			+ COLUMN_ID
			+ " INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,"
			+ COLUMN_LINEMAN_CUST_NAME
			+ " TEXT NOT NULL, "
			+ COLUMN_LINEMAN_CUST_ID
			+ " TEXT NOT NULL, "
			+ COLUMN_LINEMAN_COMP_ID
			+ " TEXT NOT NULL, "
			+ COLUMN_LINEMAN_CUST_MOB
			+ " TEXT NOT NULL, "
			+ COLUMN_LINEMAN_CUST_ADD
			+ " TEXT NOT NULL, "
			+ COLUMN_LINEMAN_REPORTEDDATE
			+ " TEXT NOT NULL ,"
			+ COLUMN_LINEMAN_RESOLVEDATE
			+ " TEXT )"
			;
	
	private static final String DATABASE_CREATE_LINEMAN_CATEGORY_TBL = "CREATE TABLE IF NOT EXISTS "
			+ TABLE_LINEMAN_CATEGORY+ "("
			+ COLUMN_ID	+ " INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,"
			+ COLUMN_LINEMAN_CAT_ID	+ " TEXT NOT NULL, "
			+ COLUMN_LINEMAN_CAT_NAME+ " TEXT NOT NULL )";

	public DataStoreHandler(Context context) {
		super(context, DATABASE_NAME, null, DATABASE_VERSION);
	}

	@Override
	public void onCreate(SQLiteDatabase database) {
		database.execSQL(DATABASE_CREATE_LINEMAN_PENDINGLIST_TBL);
		database.execSQL(DATABASE_CREATE_LINEMAN_CATEGORY_TBL);
	}

	@Override
	public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {

	}

}