package com.hrpdss.android.activity;

import android.annotation.TargetApi;
import android.app.AppOpsManager;
import android.content.Context;
import android.content.Intent;
import android.os.Build;
import android.os.Bundle;
import android.os.Handler;
import android.provider.Settings;
import android.support.v7.app.AppCompatActivity;
import android.view.KeyEvent;
import android.widget.ProgressBar;
import android.widget.RelativeLayout;

import com.hrpdss.android.R;
import com.hrpdss.android.storage.SavePreferences;
import com.hrpdss.android.volley.Application;
import com.hrpdss.android.volley.Constant;
import com.hrpdss.kiosk.SampleAlarmReceiver;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

/**
 * Created by Namrata on 3/14/2016.
 */
public class SplashActivity extends AppCompatActivity {
    private final List blockedKeys = new ArrayList(Arrays.asList(KeyEvent.KEYCODE_VOLUME_DOWN, KeyEvent.KEYCODE_VOLUME_UP));
    //Declaring all class level variables
    private static int SPLASH_TIME_OUT = 2000;
    ProgressBar pbar;
    RelativeLayout rellayParent;
SavePreferences savePreferences;
    boolean granted=false;
    SampleAlarmReceiver alarm = new SampleAlarmReceiver();
    @TargetApi(Build.VERSION_CODES.KITKAT)
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_splash);
        savePreferences=new SavePreferences();
        alarm.setAlarm(getApplicationContext());

//        System.out.println("111 granted"+granted);

        loginSavedUser();
    }

    private void loginSavedUser() {
        new Handler().postDelayed(new Runnable() {
            @Override
            public void run() {
                if(granted==true){
                    if (savePreferences.getPreferences_integer(getApplicationContext(), Constant.loginaccessTocken) == 1) {
                        Intent homeIntent = new Intent(SplashActivity.this, HomeActivity.class);
                        homeIntent.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                        getApplicationContext().startActivity(homeIntent);
                    } else {
                        Intent myintent = new Intent(getApplicationContext(), LoginActivity.class);
                        myintent.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                        getApplicationContext().startActivity(myintent);
                    }
                    finish();

                }
                else{
                    final Intent intent = new Intent(Settings.ACTION_USAGE_ACCESS_SETTINGS);
                    startActivity(intent);
                }

            }
        }, SPLASH_TIME_OUT);
    }

    @Override
    public void onBackPressed() {
//        super.onBackPressed();
    }

    @TargetApi(Build.VERSION_CODES.KITKAT)
    @Override
    protected void onResume() {
        super.onResume();
        Application.getInstance().trackScreenView("Splash Screen");
        AppOpsManager appOps = (AppOpsManager) this
                .getSystemService(Context.APP_OPS_SERVICE);
        int mode = appOps.checkOpNoThrow("android:get_usage_stats",
                android.os.Process.myUid(), this.getPackageName());
        granted = mode == AppOpsManager.MODE_ALLOWED;
        loginSavedUser();

    }
    @Override
    public boolean dispatchKeyEvent(KeyEvent event) {
        if (blockedKeys.contains(event.getKeyCode())) {
            return true;
        } else {
            return super.dispatchKeyEvent(event);
        }
    }
}
