package com.hrpdss.android.volley;

import android.content.Intent;
import android.text.TextUtils;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.ImageLoader;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;
import com.google.android.gms.analytics.GoogleAnalytics;
import com.google.android.gms.analytics.HitBuilders;
import com.google.android.gms.analytics.StandardExceptionParser;
import com.google.android.gms.analytics.Tracker;
import com.hrpdss.android.listadapter.Category;
import com.hrpdss.android.storage.SavePreferences;
import com.hrpdss.kiosk.KioskService;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

/**
 * Created by Abhishek on 4/15/2016.
 */
public class Application extends android.app.Application {
//	private AppContext instance;
	public static final String TAG = Application.class
			.getSimpleName();
	private RequestQueue mRequestQueue;
	private ImageLoader mImageLoader;
	private static Application mInstance;
	public static ArrayList<JSONObject> configdata = new ArrayList<>();
	public static ArrayList<Category> catlist = new ArrayList<>();
SavePreferences savepref;
	@Override
	public void onCreate() {
		super.onCreate();
		mInstance = this;
//		getAllcategory();
//		registerKioskModeScreenOffReceiver();
		savepref=new SavePreferences();
		startKioskService();
		AnalyticsTrackers.initialize(this);
		AnalyticsTrackers.getInstance().get(AnalyticsTrackers.Target.APP);
		getconfigData();
	}

	public static synchronized Application getInstance() {
		return mInstance;
	}
	public synchronized Tracker getGoogleAnalyticsTracker() {
		AnalyticsTrackers analyticsTrackers = AnalyticsTrackers.getInstance();
		return analyticsTrackers.get(AnalyticsTrackers.Target.APP);
	}
	public void trackScreenView(String screenName) {
		Tracker t = getGoogleAnalyticsTracker();

		// Set screen name.
		t.setScreenName(screenName);

		// Send a screen view.
		t.send(new HitBuilders.ScreenViewBuilder().build());

		GoogleAnalytics.getInstance(this).dispatchLocalHits();
	}
	public void trackException(Exception e) {
		if (e != null) {
			Tracker t = getGoogleAnalyticsTracker();

			t.send(new HitBuilders.ExceptionBuilder()
							.setDescription(
									new StandardExceptionParser(this, null)
											.getDescription(Thread.currentThread().getName(), e))
							.setFatal(false)
							.build()
			);
		}
	}
	public void trackEvent(String category, String action, String label) {
		Tracker t = getGoogleAnalyticsTracker();

		// Build and send an Event.
		t.send(new HitBuilders.EventBuilder().setCategory(category).setAction(action).setLabel(label).build());
	}
	public RequestQueue getRequestQueue() {
		if (mRequestQueue == null) {
			mRequestQueue = Volley.newRequestQueue(getApplicationContext());
		}

		return mRequestQueue;
	}

	public ImageLoader getImageLoader() {
		getRequestQueue();
		if (mImageLoader == null) {
			mImageLoader = new ImageLoader(this.mRequestQueue,
					new BitmapCache());
		}
		return this.mImageLoader;
	}

	public <T> void addToRequestQueue(Request<T> req, String tag) {
		// set the default tag if tag is empty
		req.setTag(TextUtils.isEmpty(tag) ? TAG : tag);
		getRequestQueue().add(req);
	}

	public <T> void addToRequestQueue(Request<T> req) {
		req.setTag(TAG);
		getRequestQueue().add(req);
	}

	public void cancelPendingRequests(Object tag) {
		if (mRequestQueue != null) {
			mRequestQueue.cancelAll(tag);
		}
	}
	private void getconfigData() {
		configdata.clear();
		JSONObject obj = new JSONObject();
		JsonObjectRequest jsonObjReq = new JsonObjectRequest(Request.Method.GET,
				Constant.bb_vandor_baseUrl + "getSettings" , null,
				new Response.Listener<JSONObject>() {
					@Override
					public void onResponse(JSONObject response) {
						try {
							if (response!=null || response.length()>0) {
								JSONArray resourceArr = response.getJSONArray("response");
								for (int i = 0; i < resourceArr.length(); i++) {
									configdata.add(resourceArr.getJSONObject(i));
								}
								System.out.println("111 configdata"+configdata+">>>>"+configdata.size());
						savepref.SavePreferences(mInstance,configdata.get(0).getString("name").toString(),configdata.get(0).getString("value").toString());
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




	private void startKioskService() { // ... and this method
		startService(new Intent(this, KioskService.class));
	}
}
