package com.hrpdss.kiosk;

import android.annotation.TargetApi;
import android.app.AlarmManager;
import android.app.PendingIntent;
import android.content.ComponentName;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.os.Build;
import android.os.SystemClock;
import android.support.v4.content.WakefulBroadcastReceiver;


public class SampleAlarmReceiver extends WakefulBroadcastReceiver {
    // The app's AlarmManager, which provides access to the system alarm services.
    private AlarmManager alarmMgr;
    // The pending intent that is triggered when the alarm fires.
    private PendingIntent alarmIntent;
    final int sec=1;
  
    @Override
    public void onReceive(Context context, Intent intent) {
        if(KioskService.running==false) {
            Intent service = new Intent(context, KioskService.class);
//        Toast.makeText(context,"Onreceive",Toast.LENGTH_LONG).show();
            // Start the service, keeping the device awake while it is launching.
            startWakefulService(context, service);

        setAlarm(context);
        }
    }
    @TargetApi(Build.VERSION_CODES.KITKAT)
    public void setAlarm(Context context) {
//        Toast.makeText(context,"setalarm",Toast.LENGTH_LONG).show();
//        if(KioskService.running==false) {
//            KioskService.running=true;
            alarmMgr = (AlarmManager) context.getSystemService(Context.ALARM_SERVICE);
            Intent intent = new Intent(context, SampleAlarmReceiver.class);
            alarmIntent = PendingIntent.getBroadcast(context, 0, intent, 0);

//        alarmMgr.set(AlarmManager.ELAPSED_REALTIME_WAKEUP, 
//                         SystemClock.elapsedRealtime() +
//                         1000*sec, alarmIntent);
            alarmMgr.setExact(AlarmManager.ELAPSED_REALTIME_WAKEUP, SystemClock.elapsedRealtime(), alarmIntent);
            alarmMgr.setInexactRepeating(AlarmManager.ELAPSED_REALTIME_WAKEUP, SystemClock.elapsedRealtime(), sec * 100, alarmIntent);
            // Enable {@code SampleBootReceiver} to automatically restart the alarm when the
            // device is rebooted.
            ComponentName receiver = new ComponentName(context, BootReceiver.class);
            PackageManager pm = context.getPackageManager();

            pm.setComponentEnabledSetting(receiver,
                    PackageManager.COMPONENT_ENABLED_STATE_ENABLED,
                    PackageManager.DONT_KILL_APP);
        }
//    }
    // END_INCLUDE(set_alarm)

    /**
     * Cancels the alarm.
     * @param context
     */
    // BEGIN_INCLUDE(cancel_alarm)
    public void cancelAlarm(Context context) {
        // If the alarm has been set, cancel it.
    	alarmMgr = (AlarmManager)context.getSystemService(Context.ALARM_SERVICE);
    	Intent intent = new Intent(context, SampleAlarmReceiver.class);
        alarmIntent = PendingIntent.getBroadcast(context, 0, intent, 0);

        if (alarmMgr!= null) {
            alarmMgr.cancel(alarmIntent);
        }
        System.out.println("111 at alarm cancel");
        // Disable {@code SampleBootReceiver} so that it doesn't automatically restart the 
        // alarm when the device is rebooted.
        ComponentName receiver = new ComponentName(context, BootReceiver.class);
        PackageManager pm = context.getPackageManager();

        pm.setComponentEnabledSetting(receiver,
                PackageManager.COMPONENT_ENABLED_STATE_DISABLED,
                PackageManager.DONT_KILL_APP);
    }
    // END_INCLUDE(cancel_alarm)
}
