package com.hrpdss.android.gcm;

import android.annotation.SuppressLint;
import android.app.IntentService;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.content.Context;
import android.content.Intent;
import android.media.RingtoneManager;
import android.net.Uri;
import android.os.Bundle;
import android.support.v4.app.NotificationCompat;
import android.widget.RemoteViews;

import com.google.android.gms.gcm.GoogleCloudMessaging;
import com.hrpdss.android.R;
import com.hrpdss.android.activity.HomeActivity;

import org.json.JSONObject;

import java.util.ArrayList;
import java.util.Date;


@SuppressLint("SimpleDateFormat")
public class GcmIntentService extends IntentService {
	public static final int NOTIFICATION_ID = 1;
	boolean dbmsgcheck=false;
	private NotificationManager mNotificationManager;
	NotificationCompat.Builder builder;
	public static final String TAG = "GcmIntentService";
	String msg_id="", message="",currentDateTimeString="";
	private Date date;
	ArrayList<JSONObject> newMessageArr =  new ArrayList<JSONObject>();

	public GcmIntentService() {
		super("GcmIntentService");
	}

	@Override
	protected void onHandleIntent(Intent intent) {
		System.out.println("111 GcmIntentService onHandleIntent");
//    	date=new Date();
//    	currentDateTimeString=new SimpleDateFormat("MM/dd/yyyy HH:mm").format(date);
		if(intent != null)
		{
			Bundle extras = intent.getExtras();
			GoogleCloudMessaging gcm = GoogleCloudMessaging.getInstance(getApplicationContext());
			String messageType = gcm.getMessageType(intent);
			if (!extras.isEmpty()) { // has effect of unparcelling Bundle
				if (GoogleCloudMessaging.MESSAGE_TYPE_SEND_ERROR.equals(messageType)) {
					sendNotification("Send error: " + extras.toString(), "");
				} else if (GoogleCloudMessaging.MESSAGE_TYPE_DELETED.equals(messageType)) {
					sendNotification("Deleted messages on server: "	+ extras.toString(), "");
					// If it's a regular GCM message, do some work.
				} else if (GoogleCloudMessaging.MESSAGE_TYPE_MESSAGE.equals(messageType)) 
				{
					if(extras.getString("message") != null)
					{
//						msg_id = extras.getString("id");
						message = extras.getString("message");
						sendFirstNotification(message);
						/*try {
						String datefromServer=extras.getString("modification_date");
						String notification_id=extras.getString("id");
						if(notification_id==null){
							if(sharedpref.getPreferences_integer(getApplicationContext(),"ntcount")==1){
								sendFirstNotification(message);
							}
						}
						else{
						if(sharedpref.getPreferences_integer(getApplicationContext(), "notification_id")<Integer.parseInt(notification_id)){
						sharedpref.SavePreferences(getApplicationContext(), "notification_id",Integer.parseInt(notification_id));}
						SimpleDateFormat df = new SimpleDateFormat("MM/dd/yyyy HH:mm");
						date = df.parse(NotificationsActivity.convertserverDateTime(datefromServer));
						System.out.println("111 notification service"+message);
						sendNotification(message,NotificationsActivity.getTimePassed(date));
						if(ChecktaskmsgToDataBase(message)==false){
						gcmobj.setNotificationMessage(message);
						if(datefromServer!=""||datefromServer!=null){
							System.out.println("111 date from server"+NotificationsActivity.convertserverDateTime(datefromServer));
							gcmobj.setDateTime(NotificationsActivity.convertserverDateTime(datefromServer));
							
							}
						else{
							gcmobj.setDateTime(currentDateTimeString);
						}
//						
						gcmobj.setNotificationstatus("0");
	        			DataSourceHandler db = DataSourceHandler.getInstance(getApplicationContext());
	        			db.insertNotificationDataObject(gcmobj);
						}
						}
					} catch (ParseException e) {
//						// TODO Auto-generated catch block
//						e.printStackTrace();
					}
						Log.i(TAG, "Received: " + extras.toString());*/
					}
				}
			}
			// Release the wake lock provided by the WakefulBroadcastReceiver.
//			LocalBroadcastManager localBroadcastManager = LocalBroadcastManager.getInstance(getApplicationContext());
//   			localBroadcastManager.sendBroadcast(intent);
   			GcmBroadcastReceiver.completeWakefulIntent(intent);
   			
   		
   			
			
		}
	}
	/*private boolean ChecktaskmsgToDataBase(String msg) {
		try {
			DataSourceHandler db = DataSourceHandler.getInstance(getApplicationContext());
			List<DbPendingObject> value = db.getAllNotificationDataObject();
			for (DbPendingObject valueName : value) {
				String dbmsg = valueName.getNotificationMessage();
				if (dbmsg.equalsIgnoreCase(msg)) {
					dbmsgcheck=true;
					return dbmsgcheck;
				} 
				else {
					dbmsgcheck=false;
					return dbmsgcheck;
				}
			}
		} catch (Exception e) {
			e.printStackTrace();
			e.getLocalizedMessage();
		}
		return dbmsgcheck;
	}*/

	// Put the message into a notification and post it.
	// This is just one simple example of what you might choose to do with
	// a GCM message.
	private void sendNotification(String msg, String datetime) {
		mNotificationManager = (NotificationManager) this.getSystemService(Context.NOTIFICATION_SERVICE);
		Intent intent = new Intent(this, HomeActivity.class);
		RemoteViews remoteViews = new RemoteViews(getPackageName(), R.layout.statusbarlayout_notification);

		  PendingIntent contentIntent = PendingIntent.getActivity(this, 0,intent, PendingIntent.FLAG_CANCEL_CURRENT);
		  Uri alarmSound = RingtoneManager.getDefaultUri(RingtoneManager.TYPE_NOTIFICATION);

		  NotificationCompat.Builder mBuilder = new NotificationCompat.Builder(
		    this).setSmallIcon(R.mipmap.logo )
		    //.setContentTitle("New Message Notification")
		    //.setStyle(new NotificationCompat.BigTextStyle().bigText(msg))
		    .setAutoCancel(true)
		    .setContent(remoteViews)
		    .setSound(alarmSound)
		    .setSmallIcon(getNotificationIcon())
		    .setOnlyAlertOnce(true)
		    .setPriority(NotificationCompat.PRIORITY_HIGH)
		    .setCategory(NotificationCompat.CATEGORY_SOCIAL)
		    .setContentText(msg);
		  remoteViews.setTextViewText(R.id.txt_event_item_title,msg);
		  remoteViews.setTextViewText(R.id.txt_event_item_datetime,datetime);
		  mBuilder.setContentIntent(contentIntent);
		  mNotificationManager.notify(NOTIFICATION_ID, mBuilder.build());

	}
	private int getNotificationIcon() {
		  boolean whiteIcon = (android.os.Build.VERSION.SDK_INT >= android.os.Build.VERSION_CODES.LOLLIPOP);
		  return whiteIcon ? R.mipmap.logo : R.mipmap.logo;
		 }
	private void sendFirstNotification(String msg) {
		mNotificationManager = (NotificationManager) this.getSystemService(Context.NOTIFICATION_SERVICE);
		Intent intent = new Intent(this, HomeActivity.class);
		RemoteViews remoteViews = new RemoteViews(getPackageName(), R.layout.statusbarlayout_notification);  

		  PendingIntent contentIntent = PendingIntent.getActivity(this, 0,intent, PendingIntent.FLAG_CANCEL_CURRENT);
		  Uri alarmSound = RingtoneManager.getDefaultUri(RingtoneManager.TYPE_NOTIFICATION);

		  NotificationCompat.Builder mBuilder = new NotificationCompat.Builder(
		    this).setSmallIcon(R.mipmap.logo )
		    //.setContentTitle("New Message Notification")
		    //.setStyle(new NotificationCompat.BigTextStyle().bigText(msg))
		    .setAutoCancel(true)
		    .setContent(remoteViews)
		    .setSound(alarmSound)
		    .setSmallIcon(getNotificationIcon())
		    .setOnlyAlertOnce(true)
		    .setPriority(NotificationCompat.PRIORITY_HIGH)
		    .setCategory(NotificationCompat.CATEGORY_SOCIAL)
		    .setContentText(msg);
		  remoteViews.setTextViewText(R.id.txt_event_item_title,msg);
		  remoteViews.setTextViewText(R.id.txt_event_item_datetime,"");
		  mBuilder.setContentIntent(contentIntent);
		  mNotificationManager.notify(NOTIFICATION_ID, mBuilder.build());

	}
}