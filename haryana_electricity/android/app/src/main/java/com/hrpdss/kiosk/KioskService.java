package com.hrpdss.kiosk;

import android.app.ActivityManager;
import android.app.Service;
import android.app.usage.UsageStats;
import android.app.usage.UsageStatsManager;
import android.content.ComponentName;
import android.content.Context;
import android.content.Intent;
import android.os.IBinder;
import android.util.Log;

import com.hrpdss.android.activity.SplashActivity;
import com.hrpdss.android.storage.SavePreferences;
import com.hrpdss.android.volley.Constant;

import java.util.List;
import java.util.SortedMap;
import java.util.TreeMap;
import java.util.concurrent.TimeUnit;
/**
 * Created by Abhishek on 30.06.2016.
 */
public class KioskService extends Service{
SavePreferences savePreferences=new SavePreferences();
    private static final long INTERVAL = TimeUnit.SECONDS.toMillis(1); // periodic interval to check in seconds -> 2 seconds
    private static final String TAG = KioskService.class.getSimpleName();

    private Thread t = null;
    private Context ctx = null;
    public static boolean running = false;

    @Override
    public void onDestroy() {
//        Log.e(TAG, "Stopping service 'KioskService'");
        running =false;

        super.onDestroy();
       sendBroadcast(new Intent("YouWillNeverKillMe"));
    }

    @Override
    public int onStartCommand(Intent intent, int flags, int startId) {
//        Log.e(TAG, "Starting service 'KioskService'");
//        System.out.println("111 Starting service 'KioskService'");

        running = true;
        ctx = this;
//        Toast.makeText(ctx,"service running",Toast.LENGTH_LONG).show();
        // start a thread that periodically checks if your app is in the foreground
        t = new Thread(new Runnable() {
            @Override
            public void run() {
                do {
                    handleKioskMode();
                    try {
                        Thread.sleep(INTERVAL);
                    } catch (InterruptedException e) {
                        Log.i(TAG, "Thread interrupted: 'KioskService'");
                    }
                }while(running);
                stopSelf();
            }
        });

        t.start();
        return Service.START_NOT_STICKY;
    }

    private void handleKioskMode() {
        // is Kiosk Mode active?
        if(savePreferences.getPreferences_integer(ctx, Constant.Kios_Admin)<1) {
            if (runningApp()) {
                restoreApp(); // restore!
            }
        }
    }

    private boolean isInBackground() {
        boolean ismyapp=false;
        ActivityManager am = (ActivityManager) ctx.getSystemService(Context.ACTIVITY_SERVICE);

        List<ActivityManager.RunningTaskInfo> taskInfo = am.getRunningTasks(1);
        ComponentName componentInfo = taskInfo.get(0).topActivity;

        System.out.println("111 componentInfo>"+componentInfo.getPackageName());
        if(componentInfo.getPackageName().equalsIgnoreCase("com.huawei.android.launcher") ||componentInfo.getPackageName().equalsIgnoreCase("de.example.android.kiosk") ||componentInfo.getPackageName().equalsIgnoreCase("com.android.incallui") ) {
//            return (!ctx.getApplicationContext().getPackageName().equals(componentInfo.getPackageName()));
            ismyapp=false;
        }
        else{
            ismyapp=true;
        }
        return ismyapp;
    }
private boolean runningApp(){
    String currentApp="";
    boolean ismyapp=false;
//    UsageStatsManager usagestats=new UsageStatsManager();
    if (android.os.Build.VERSION.SDK_INT >= android.os.Build.VERSION_CODES.LOLLIPOP) {
        UsageStatsManager usm = (UsageStatsManager) getSystemService("usagestats");
        long time = System.currentTimeMillis();
        List<UsageStats> appList = usm.queryUsageStats(UsageStatsManager.INTERVAL_DAILY,
                time - 1000 * 1000, time);
        if (appList != null && appList.size() > 0) {
            SortedMap<Long, UsageStats> mySortedMap = new TreeMap<Long, UsageStats>();
            for (UsageStats usageStats : appList) {
                mySortedMap.put(usageStats.getLastTimeUsed(),
                        usageStats);
            }
            if (mySortedMap != null && !mySortedMap.isEmpty()) {
                currentApp = mySortedMap.get(
                        mySortedMap.lastKey()).getPackageName();
//                System.out.println("111 current App"+currentApp);
                if(currentApp.equalsIgnoreCase("com.hrpdss.android")||currentApp.contains("launcher")||currentApp.contains("googlequicksearchbox")||currentApp.contains("contacts")||currentApp.contains("dialer") || currentApp.contains("call")||currentApp.contains("mms")||currentApp.contains("messag")|| currentApp.contains("phone")|| currentApp.contains("systemui") || currentApp.equalsIgnoreCase("com.miui.home")) {
                    ismyapp=false;
                }
                else{
                    ismyapp=true;
                }
            }
        }
    }
    else {
        ActivityManager am = (ActivityManager) getBaseContext().getSystemService(ACTIVITY_SERVICE);
        currentApp = am.getRunningTasks(1).get(0).topActivity .getPackageName();
//        System.out.println("111 current App"+currentApp);
        if(currentApp.equalsIgnoreCase("com.hrpdss.android")||currentApp.contains("launcher")||currentApp.contains("googlequicksearchbox")||currentApp.contains("contacts")||currentApp.contains("dialer") || currentApp.contains("call")||currentApp.contains("mms")||currentApp.contains("messag")|| currentApp.contains("phone")|| currentApp.contains("systemui") || currentApp.equalsIgnoreCase("com.miui.home")) {
            ismyapp=false;
        }
        else{
            ismyapp=true;
        }

    }
    return ismyapp;
}
    private void restoreApp() {
        // Restart activity
        Intent i = new Intent(ctx, SplashActivity.class);
        i.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
        ctx.startActivity(i);
    }

    @Override
    public IBinder onBind(Intent intent) {
        return null;
    }
}