package com.hrpdss.android.gcm;

import android.app.Activity;
import android.content.ComponentName;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.support.v4.content.LocalBroadcastManager;
import android.support.v4.content.WakefulBroadcastReceiver;

public class GcmBroadcastReceiver extends WakefulBroadcastReceiver {
	static String id="",content="",currentDateTimeString="MM/dd/yyyy HH:mm";
		int count_notification;


	@Override
	public void onReceive(Context context, Intent intent) {
				
		// Explicitly specify that GcmIntentService will handle the intent.

		Bundle extras = intent.getExtras();
		System.out.println("111 onreceiveGcmBroadcastReceiver"+extras);
		//		&& !content.equalsIgnoreCase(extras.getString("message"))
		if(extras.getString("message") != null ){
			ComponentName comp = new ComponentName(context.getPackageName(),GcmIntentService.class.getName());
			Intent i = new Intent("NOTIFICATION_RECEIVED");
//			sharedpref=new SharedPreferencesStorage();
//			count_notification=sharedpref.getPreferences_integer(context,"ntcount");
			// Start the service, keeping the device awake while it is launching.
			startWakefulService(context, (intent.setComponent(comp)));
			setResultCode(Activity.RESULT_OK);

//			id=extras.getString("id");
			content=extras.getString("message");
			System.out.println("111 onreceiveGcmBroadcastReceiver msg"+extras.get("message"));
//			System.out.println("111 message for first time"+content);
//			sharedpref.SavePreferences(context, "ntcount", count_notification+1);
//			System.out.println("111 onreceiveGcmBroadcastReceiver"+id+"&"+content);
		
			context.sendBroadcast(i);
//			i.putExtra("unread_count", count_notification);
			LocalBroadcastManager localBroadcastManager = LocalBroadcastManager.getInstance(context);
			localBroadcastManager.sendBroadcast(i);
				}
	}

	
	
}