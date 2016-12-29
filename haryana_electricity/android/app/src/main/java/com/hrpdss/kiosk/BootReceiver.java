package com.hrpdss.kiosk;

import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;

/**
 * Created by Abhishek on 30.06.2016.
 */
public class BootReceiver extends BroadcastReceiver {
    SampleAlarmReceiver alarm = new SampleAlarmReceiver();
    @Override
    public void onReceive(Context context, Intent intent) {
        context.startService(new Intent(context, KioskService.class));
        alarm.setAlarm(context);
//        Intent myIntent = new Intent(context, SplashActivity.class);
//        myIntent.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
//        context.startActivity(myIntent);

    }
}