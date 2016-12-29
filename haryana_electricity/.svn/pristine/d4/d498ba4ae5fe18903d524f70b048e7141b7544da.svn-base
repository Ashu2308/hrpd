package com.hrpdss.android.storage;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;

import com.hrpdss.android.activity.HomeActivity;
import com.hrpdss.android.listadapter.Category;

import java.util.ArrayList;
import java.util.List;
/**
 * Created by Abhishek on 4/21/2016.
 */
public class DataSourceHandler {

	private SQLiteDatabase myDataBase;
	private DataStoreHandler dbHelper;

	private Context context;
	private static DataSourceHandler mInstance = null;
	private DataSourceHandler() {
		context= HomeActivity.mainInstance;

	}

	public static DataSourceHandler getInstance(Context ctx) {
		if (mInstance == null) {
			mInstance = new DataSourceHandler();
			mInstance.getDataSourceHandler(ctx);
		}
		return mInstance;
	}

	private void getDataSourceHandler(Context context) {
		try {
			dbHelper = new DataStoreHandler(context);
			myDataBase = dbHelper.getWritableDatabase();
		} catch (Exception e) {
			e.printStackTrace();
			close();
		}
	}

	private void close() {
		try {
			myDataBase.close();
		} catch (Exception e) {
		}
		try {
			dbHelper.close();
		} catch (Exception e) {
		}
	}

	/**
	 * Freq location base functions
	 */
	public void insertintoLINEMANPENDINGLIST(DbPendingObject obj) {
		myDataBase = dbHelper.getWritableDatabase();
		ContentValues values = new ContentValues();
		values.put(DataStoreHandler.allLINEMANPENDINGLISTColumns[1], obj.getCustomerName());
		values.put(DataStoreHandler.allLINEMANPENDINGLISTColumns[2], obj.getCustomerId());
		values.put(DataStoreHandler.allLINEMANPENDINGLISTColumns[3], obj.getComplainId());
		values.put(DataStoreHandler.allLINEMANPENDINGLISTColumns[4], obj.getCustomerMobnumber());
		values.put(DataStoreHandler.allLINEMANPENDINGLISTColumns[5], obj.getCustomerAddress());
		values.put(DataStoreHandler.allLINEMANPENDINGLISTColumns[6], obj.getReportedDate());
		values.put(DataStoreHandler.allLINEMANPENDINGLISTColumns[7], obj.getResolveDate());
		myDataBase.insert(DataStoreHandler.TABLE_LINEMAN_PENDINGLIST, null, values);
		myDataBase.close();
//		long insertId = myDataBase.insert(DataStoreHandler.TABLE_LINEMAN_PENDINGLIST, null, values);

//		return insertId;
		
	}

	/*public int updateFreqLocationDataObject(DbPendingObject obj) {
		ContentValues values = new ContentValues();
		values.put(DataStoreHandler.allFreqLocationColumns[1], obj.getDate());
		values.put(DataStoreHandler.allFreqLocationColumns[2],
				obj.getLocationLat());
		values.put(DataStoreHandler.allFreqLocationColumns[3],
				obj.getLocationLong());
		values.put(DataStoreHandler.allFreqLocationColumns[4],
				obj.getLocatonType());
		values.put(DataStoreHandler.allFreqLocationColumns[5],
				obj.getLocatonProvider());
		values.put(DataStoreHandler.allFreqLocationColumns[6], obj.getMessage());
		values.put(DataStoreHandler.allFreqLocationColumns[7], obj.getRepeate());
		values.put(DataStoreHandler.allFreqLocationColumns[8], obj.getMapradius());
		values.put(DataStoreHandler.allFreqLocationColumns[9], obj.getTasktype());
		values.put(DataStoreHandler.allFreqLocationColumns[10], obj.getTaskname());
		int updated = myDataBase.update(DataStoreHandler.TABLE_FREQ_LOCATION,
				values,
				DataStoreHandler.allFreqLocationColumns[0] + "=" + obj.getId(),
				null);
//		System.out.println("1111at update in db>>>>>>>>"+obj.getLocatonType());
		return updated;
	}*/
	/*public int updateRepeatLocationDataObject(DbPendingObject obj) {
		ContentValues values = new ContentValues();
			values.put(DataStoreHandler.allFreqLocationColumns[7], obj.getRepeate());
			int updated = myDataBase.update(DataStoreHandler.TABLE_FREQ_LOCATION,
				values,
				DataStoreHandler.allFreqLocationColumns[0] + "=" + obj.getId(),
				null);
		return updated;
	}
	public void deleteFreqLocationDataObject(DbPendingObject object) {
		long id = object.getId();
		myDataBase.delete(DataStoreHandler.TABLE_FREQ_LOCATION,
				DataStoreHandler.COLUMN_ID + " = " + id, null);
		
	}*/
	public void deleteAllPendingListData(){
		myDataBase = dbHelper.getWritableDatabase();
	myDataBase.delete(DataStoreHandler.TABLE_LINEMAN_PENDINGLIST,null,null);
		myDataBase.close();
	}

	public List<DbPendingObject> getAllLINEMANPENDINGLIST() {
		myDataBase = dbHelper.getWritableDatabase();
		List<DbPendingObject> dataArr = new ArrayList<DbPendingObject>();
		Cursor cursor = myDataBase.query(DataStoreHandler.TABLE_LINEMAN_PENDINGLIST,
				DataStoreHandler.allLINEMANPENDINGLISTColumns, null, null, null,
				null, null);
		if (cursor != null && cursor.moveToFirst()) {
			while (!cursor.isAfterLast()) {
				DbPendingObject data = cursorToFreqLocationDataObject(cursor);
				dataArr.add(data);
				cursor.moveToNext();
			}
		}
		if (cursor != null && !cursor.isClosed()) {
			cursor.close();
		}
		myDataBase.close();
		return dataArr;
	}
	public void insertallCategoryData(Category obj) {
		myDataBase = dbHelper.getWritableDatabase();
		ContentValues values = new ContentValues();
		values.put(DataStoreHandler.getallLINEMANCATEGORYColumns[1], obj.getId());
		values.put(DataStoreHandler.getallLINEMANCATEGORYColumns[2], obj.getName());
//		values.put(DataStoreHandler.getallrecentLocationColumns[3], obj.getLocatonType());
		myDataBase.insert(DataStoreHandler.TABLE_LINEMAN_CATEGORY,null, values);
//		long insertId = myDataBase.insert(DataStoreHandler.TABLE_LINEMAN_CATEGORY,null, values);
//		return insertId;
		myDataBase.close();
	}
	public void deleteAllCategoryData(){
		myDataBase = dbHelper.getWritableDatabase();
		myDataBase.delete(DataStoreHandler.TABLE_LINEMAN_CATEGORY,null,null);
		myDataBase.close();
	}
	public List<Category> getAllCategoryDataObject() {
		myDataBase = dbHelper.getWritableDatabase();
		List<Category> dataArr = new ArrayList<Category>();
		Cursor cursor = myDataBase.query(DataStoreHandler.TABLE_LINEMAN_CATEGORY,
				DataStoreHandler.getallLINEMANCATEGORYColumns, null, null, null,
				null, null);
		if (cursor != null && cursor.moveToFirst()) {
			while (!cursor.isAfterLast()) {
				Category data = cursorToallCategoryDataObject(cursor);
				dataArr.add(data);
				cursor.moveToNext();
			}
		}

//		List<DbPendingObject> dataArr = new ArrayList<DbPendingObject>();
//		Cursor cursor = myDataBase.query(DataStoreHandler.TABLE_RECENT_SEARCH_LOCATION,
//				DataStoreHandler.getallrecentLocationColumns, null, null, null,
//				null, null);
//		if(cursor != null && cursor.moveToFirst()) {
//		    int curSize=cursor.getCount();  // return no of rows
//		    if(curSize>10) {
//		       int lastTenValue=curSize -10;
//		       for(int i=curSize;i<lastTenValue;i--){
//		    	   DbPendingObject data = cursorToRecentSearchLocationDataObject(cursor);
//					dataArr.add(data);
//		    	   cursor.moveToNext();
//		       }
//		    } else {
//		    	for(int i=curSize;i<=0;i--){
//		    	DbPendingObject data = cursorToRecentSearchLocationDataObject(cursor);
//				dataArr.add(data);
//		    	cursor.moveToNext();
//		    	}
//		    }
//		}
		if (cursor != null && !cursor.isClosed()) {
			cursor.close();
		}
		myDataBase.close();
		return dataArr;
	}


	private DbPendingObject cursorToFreqLocationDataObject(Cursor cursor) {
		DbPendingObject data = new DbPendingObject();
		data.setCustomerName(cursor.getString(1));
		data.setCustomerId(cursor.getString(2));
		data.setComplainId(cursor.getString(3));
		data.setCustomerMobnumber(cursor.getString(4));
		data.setCustomerAddress(cursor.getString(5));
		data.setReportedDate(cursor.getString(6));
		data.setResolveDate(cursor.getString(7));

		return data;
	}
	private Category cursorToallCategoryDataObject(Cursor cursor) {
		Category data = new Category();

		data.setId(cursor.getString(1));
		data.setName(cursor.getString(2));
//		data.setIsSelected(cursor.get(3));
		return data;
	}
}
