package com.hrpdss.android.gcm;

import android.annotation.SuppressLint;
import android.content.Context;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.telephony.TelephonyManager;
import android.util.Log;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.GooglePlayServicesUtil;
import com.google.android.gms.gcm.GoogleCloudMessaging;
import com.hrpdss.android.volley.Application;
import com.hrpdss.android.volley.Constant;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.HashMap;
import java.util.Map;

//Api Key-AIzaSyCZLBS6FUzl3trd2vaON9IQuRXEPvSCJdg
//Server kEy-AIzaSyA50SfC2dQ-tcWo7xuV0pQxlIOgXVI2J2s
@SuppressLint("HandlerLeak")
public class GCMmanager {
	static GoogleCloudMessaging gcm;
	static String SENDER_ID = "607605264523";
	static String regid;
	static String userId="",deviceid="";
	

	public static void startRegistration(Context context, String userID) {
		userId=userID;
		if (checkPlayServices(context)) {

			deviceid=getIMEI(context);
			gcm = GoogleCloudMessaging.getInstance(context);
			registerInBackground(context);

		} else {
			//Log.i(TAG, "No valid Google Play Services APK found.");
		}

	}
	public static String getIMEI(Context context){
		TelephonyManager mngr = (TelephonyManager) context.getSystemService(Context.TELEPHONY_SERVICE); 
		String imei = mngr.getDeviceId();
		return imei;

	}
	private static boolean checkPlayServices(Context context) {
		int resultCode = GooglePlayServicesUtil.isGooglePlayServicesAvailable(context);
		if (resultCode != ConnectionResult.SUCCESS) {
			if (GooglePlayServicesUtil.isUserRecoverableError(resultCode)) {
				Log.v("NO GOOGLE", "No Google Play Services...Get it from the store.");
				//GooglePlayServicesUtil.getErrorDialog(resultCode, this,PLAY_SERVICES_RESOLUTION_REQUEST).show();
			} else {
				Log.v("No google services", "This device is not supported.");

			}
			return false;
		}
		return true;
	}


	private static void registerInBackground(final Context context) {

		new AsyncTask<Void, Void, String>() {
			@Override
			protected String doInBackground(Void... params) {
				String msg = "";
				try {
					if (gcm == null) {
						gcm = GoogleCloudMessaging.getInstance(context);
					}
					regid = gcm.register(SENDER_ID);
					msg = "Device registered, registration ID=" + regid;
				} catch (IOException ex) {
					msg = ex.getMessage();
				}
				return msg;
			}

			@Override
			protected void onPostExecute(String msg) {
				System.out.println("111 GCM registered id"+msg);

				if (!msg.equalsIgnoreCase("SERVICE_NOT_AVAILABLE")) {

					Message msgObj = handler.obtainMessage();
					Bundle b = new Bundle();
					b.putString("server_response", msg);
					msgObj.setData(b);
					handler.sendMessage(msgObj);
					updateGCMID(regid,userId);

				}
			}
			private final Handler handler = new Handler() {

				public void handleMessage(Message msg) {

					String aResponse = msg.getData().getString(
							"server_response");

					if ((null != aResponse)) {



					}

				}
			};
		}.execute(null, null, null);
	}

	private static void updateGCMID(String regid, String userId) {
//		JSONObject obj = new JSONObject();
		System.out.println("111 updateGCMID"+Constant.bb_vandor_baseUrl + "updateGCMID/" + userId + "/" + regid);
		JsonObjectRequest jsonObjReq = new JsonObjectRequest(Request.Method.GET,

				Constant.bb_vandor_baseUrl + "updateGCMID/" + userId + "/" + regid, null,
				new Response.Listener<JSONObject>() {
					@Override
					public void onResponse(JSONObject response) {
						try {
//							System.out.println("111 updateGCMID response"+response);
							if (response.get("status_message").toString().equalsIgnoreCase("success")) {
//								System.out.println("111 updateGCMID");

							}
						} catch (JSONException e) {
							e.printStackTrace();
						}


					}
				}, new Response.ErrorListener() {

			@Override
			public void onErrorResponse(VolleyError error) {
				// VolleyLog.d(TAG, "Error: " + error.getMessage());

			}
		}) {
			@Override
			public Map<String, String> getHeaders() throws AuthFailureError {
				HashMap<String, String> headers = new HashMap<String, String>();
				headers.put("Content-Type", "application/json");
				return headers;
			}
		};
		Application.getInstance().addToRequestQueue(jsonObjReq, "jobj_req");
	}


}
