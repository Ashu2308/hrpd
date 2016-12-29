package com.hrpdss.kiosk;

import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.util.Log;

/**
 * Created by Abhishek on 05-07-2016.
 */
public class RestartService extends BroadcastReceiver {

        private static final String TAG = "RestartServiceReceiver";

        @Override
        public void onReceive(Context context, Intent intent) {
            Log.e(TAG, "onReceive");
            context.startService(new Intent(context.getApplicationContext(), KioskService.class));

        }


}
