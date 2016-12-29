package com.hrpdss.android.activity;

import android.app.Activity;
import android.app.ActivityManager;
import android.app.Dialog;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.content.res.Configuration;
import android.content.res.Resources;
import android.graphics.Color;
import android.os.Bundle;
import android.support.design.widget.Snackbar;
import android.support.design.widget.TabLayout;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;
import android.support.v4.content.LocalBroadcastManager;
import android.support.v4.view.ViewPager;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.util.DisplayMetrics;
import android.view.KeyEvent;
import android.view.MenuItem;
import android.view.View;
import android.view.Window;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.PopupMenu;
import android.widget.ProgressBar;
import android.widget.RadioButton;
import android.widget.RadioGroup;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.hrpdss.android.R;
import com.hrpdss.android.fragment.FragmentPending;
import com.hrpdss.android.fragment.FragmentResolved;
import com.hrpdss.android.gcm.GCMmanager;
import com.hrpdss.android.listadapter.Category;
import com.hrpdss.android.location.LocationTracker;
import com.hrpdss.android.storage.DataSourceHandler;
import com.hrpdss.android.storage.SavePreferences;
import com.hrpdss.android.volley.Application;
import com.hrpdss.android.volley.Constant;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.lang.reflect.Field;
import java.lang.reflect.Method;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.HashMap;
import java.util.List;
import java.util.Locale;
import java.util.Map;

/**
 * Created by Namrata on 4/8/2016.
 */
public class HomeActivity extends AppCompatActivity {
    private final List blockedKeys = new ArrayList(Arrays.asList(KeyEvent.KEYCODE_VOLUME_DOWN, KeyEvent.KEYCODE_VOLUME_UP));
    Toolbar toolbar;
    String username = "";
    ImageView imgNavMenu;
    TextView navTitle;
    RelativeLayout rellayNavMenu;
    SavePreferences savePreferences;
    LocationTracker locationTracker;
    ProgressBar progressBar;
    private Locale myLocale;
    static RelativeLayout coordinatorLayout;
    public static Context mainInstance;
    TextView textViewpending,textViewresolved;
    public static TextView textViewcount;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_home);
        initView();
        initViewPagerAndTabs();


        rellayNavMenu.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Application.getInstance().trackEvent("Menu", "Button_Click", "Home Screen");
                showPopUp(getApplicationContext(), rellayNavMenu);

            }
        });
        GCMmanager.startRegistration(getApplicationContext(), savePreferences.getPreferences_string(getApplicationContext(), Constant.loginid));
    }



    private void initView() {
        mainInstance=getApplicationContext();
        progressBar = (ProgressBar) findViewById(R.id.progressbar);
        coordinatorLayout= (RelativeLayout) findViewById(R.id.coordinatorLayout);
        savePreferences = new SavePreferences();
        username = savePreferences.getPreferences_string(getApplicationContext(), Constant.loginuserName);
        toolbar = (Toolbar) findViewById(R.id.toolbar);
//        toolbar.setNavigationIcon(R.mipmap.logo);
        toolbar.setNavigationIcon(null);
        toolbar.getMenu().clear();
        imgNavMenu = (ImageView) toolbar.findViewById(R.id.nav_img_menu);
        navTitle = (TextView) toolbar.findViewById(R.id.toolbar_title);
        rellayNavMenu = (RelativeLayout) toolbar.findViewById(R.id.nav_rellay_menu);
        setSupportActionBar(toolbar);
        getSupportActionBar().setDisplayShowHomeEnabled(false);
        getSupportActionBar().setDisplayHomeAsUpEnabled(false);
        navTitle.setText(username);

    }

    @Override
    protected void onResume() {
        super.onResume();
        Application.getInstance().trackScreenView("Home Screen");
        LocalBroadcastManager.getInstance(this).registerReceiver(mMessageReceiver, new IntentFilter("NOTIFICATION_RECEIVED"));
            getAllcategory();
    }

    @Override
    protected void onPause() {
        super.onPause();
        LocalBroadcastManager.getInstance(this).unregisterReceiver(mMessageReceiver);
    }

    private BroadcastReceiver mMessageReceiver = new BroadcastReceiver() {
        @Override
        public void onReceive(Context context, Intent intent) {
//			Bundle extras = intent.getExtras();
           /* if(sharedpref.getPreferences_integer(context,"ntcount")>1){
                notification_layout.setVisibility(View.VISIBLE);
                txt_count.setText(""+(sharedpref.getPreferences_integer(context,"ntcount")-1));
            }*/
        }

    };
    private void initViewPagerAndTabs() {
//        pendingCount = serviceCaller.loadPendingRequests();
        ViewPager viewPager = (ViewPager) findViewById(R.id.viewPager);
        PagerAdapter pagerAdapter = new PagerAdapter(getSupportFragmentManager());
        TabLayout tabLayout = (TabLayout) findViewById(R.id.tabLayout);
        pagerAdapter.addFragment(new FragmentPending(), getResources().getString(R.string.pending));
        pagerAdapter.addFragment(new FragmentResolved(), getResources().getString(R.string.resolved));
        pagerAdapter.notifyDataSetChanged();
        viewPager.setAdapter(pagerAdapter);
        tabLayout.setupWithViewPager(viewPager);
        View pending = View.inflate(getApplicationContext(), R.layout.custom_tab, null);
        textViewcount = (TextView) pending.findViewById(R.id.count);
        textViewpending=(TextView) pending.findViewById(R.id.titttle);
        tabLayout.getTabAt(0).setCustomView(pending);
        View resolved = View.inflate(getApplicationContext(), R.layout.custom_tab_resolved, null);
        textViewresolved = (TextView) resolved.findViewById(R.id.titttleresolved);
        tabLayout.getTabAt(1).setCustomView(resolved);
        viewPager.addOnPageChangeListener(new ViewPager.OnPageChangeListener() {
            @Override
            public void onPageScrolled(int position, float positionOffset, int positionOffsetPixels) {

            }

            @Override
            public void onPageSelected(int position) {
//                System.out.println("111 on page selected"+position);
                if(position==0){
                    textViewpending.setTextColor(getResources().getColor(R.color.white));
                    textViewcount.setTextColor(getResources().getColor(R.color.white));
                    textViewresolved.setTextColor(getResources().getColor(R.color.grey));
                }
                if(position==1){
                    textViewpending.setTextColor(getResources().getColor(R.color.grey));
                    textViewcount.setTextColor(getResources().getColor(R.color.grey));
                    textViewresolved.setTextColor(getResources().getColor(R.color.white));
                }

            }

            @Override
            public void onPageScrollStateChanged(int state) {

            }
        });


    }



    private void showPopUp(Context activity, View v) {
        PopupMenu popup = new PopupMenu(activity, v);
        try {
            Field[] fields = popup.getClass().getDeclaredFields();
            for (Field field : fields) {
                if ("mPopup".equals(field.getName())) {
                    field.setAccessible(true);
                    Object menuPopupHelper = field.get(popup);
                    Class<?> classPopupHelper = Class.forName(menuPopupHelper.getClass().getName());
                    Method setForceIcons = classPopupHelper.getMethod("setForceShowIcon", boolean.class);
                    setForceIcons.invoke(menuPopupHelper, true);
                    break;
                }
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
        popup.getMenuInflater().inflate(R.menu.menu, popup.getMenu());
        popup.setOnMenuItemClickListener(new PopupMenu.OnMenuItemClickListener() {
            public boolean onMenuItemClick(MenuItem item) {
                if (item.getItemId() == R.id.action_logout) {
                    locationTracker = new LocationTracker(getApplicationContext());
                    if (locationTracker.isConnectingToInternet()) {
                        if (locationTracker.canGetLocation()) {
                            Application.getInstance().trackEvent("Logout", "Button_Click", "Home Screen");
                            calllogout(HomeActivity.this);


                        } else {
                            locationTracker.showSettingsAlert(HomeActivity.this);
//                            showSnakBar(getResources().getString(R.string.toastlocationmsg));
//                            Toast.makeText(getApplicationContext(), getResources().getString(R.string.toastaddressmsg), Toast.LENGTH_SHORT).show();
                        }
                    } else {
//                        Toast.makeText(getApplicationContext(), getResources().getString(R.string.toastinternetmsg), Toast.LENGTH_SHORT).show();
                        showSnakBar(getResources().getString(R.string.toastinternetmsg));
                    }


                }
                if (item.getItemId() == R.id.action_hindi) {
                    Application.getInstance().trackEvent("Change Language", "Button_Click", "Home Screen");
                    choeslanguagePopUp(HomeActivity.this);

                }
                if(item.getItemId()==R.id.action_kiosk){
                    Application.getInstance().trackEvent("Kiosk Mode", "Button_Click", "Home Screen");
                    callkioskDialog(HomeActivity.this);
                }

                return true;
            }
        });
        popup.show();
    }

    private void choeslanguagePopUp(Activity context) {
        final Dialog dialog = new Dialog(context);
        DisplayMetrics metrics = getResources().getDisplayMetrics();
        int width = metrics.widthPixels;
        int height = metrics.heightPixels;
        dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
        dialog.setContentView(R.layout.dialog_change_language);
        dialog.getWindow().setLayout((6 * width) / 7, RelativeLayout.LayoutParams.WRAP_CONTENT);
        dialog.setCanceledOnTouchOutside(false);
        RadioGroup language = (RadioGroup) dialog.findViewById(R.id.language);
        RadioButton lan_english = (RadioButton) dialog.findViewById(R.id.lan_english);
        RadioButton lan_hindi = (RadioButton) dialog.findViewById(R.id.lan_hindi);
        if (savePreferences.getPreferences_string(getApplicationContext(), "language").equalsIgnoreCase("hindi")) {
            lan_hindi.setChecked(true);

        } else {
            lan_english.setChecked(true);
        }
        language.setOnCheckedChangeListener(new RadioGroup.OnCheckedChangeListener() {
            @Override
            public void onCheckedChanged(RadioGroup radioGroup, int i) {
                View radioButton = radioGroup.findViewById(i);
                int index = radioGroup.indexOfChild(radioButton);
                if (index == 0) {
                    dialog.dismiss();
                    Application.getInstance().trackEvent("Language English", "Button_Click", "Home Screen");
                    savePreferences.SavePreferences(getApplicationContext(), "language", "english");
                    setlanguage("en");
                } else if (index == 1) {
                    Application.getInstance().trackEvent("Language Hindi", "Button_Click", "Home Screen");
                    dialog.dismiss();
                    savePreferences.SavePreferences(getApplicationContext(), "language", "hindi");
                    setlanguage("hi");
                }
            }
        });

       /* dialog.setOnCancelListener(new DialogInterface.OnCancelListener() {
            @Override
            public void onCancel(DialogInterface dialog) {

            }
        });

        dialog.setOnDismissListener(new DialogInterface.OnDismissListener() {
            @Override
            public void onDismiss(DialogInterface dialog) {
                // TODO Auto-generated method stub
            }
        });*/
        dialog.setCanceledOnTouchOutside(true);
        if (!dialog.isShowing()) {
            dialog.show();
        }
    }

    private void setlanguage(String lang) {
        myLocale = new Locale(lang);
        Resources res = getResources();
        DisplayMetrics dm = res.getDisplayMetrics();
        Configuration conf = res.getConfiguration();
        conf.locale = myLocale;
        res.updateConfiguration(conf, dm);
        initViewPagerAndTabs();
//        Intent refresh = new Intent(this, HomeActivity.class);
//        startActivity(refresh);
    }

    private void backendlogout(String id, String latitude, String longitude) {
//        /getUserLogout

        final ArrayList<JSONObject> loginDetail = new ArrayList<>();
        JSONObject obj = new JSONObject();
        JsonObjectRequest jsonObjReq = new JsonObjectRequest(Request.Method.GET,
                Constant.bb_vandor_baseUrl + "getUserLogout/" + id + "/" + latitude + "/" + longitude, null,
                new Response.Listener<JSONObject>() {
                    @Override
                    public void onResponse(JSONObject response) {
                        try {
                            if (response.get("status_message").toString().equalsIgnoreCase("Logout successfully")) {
                               /* JSONArray resourceArr = response.getJSONArray("response");
//                                JSONObject obj = new JSONObject();
                                for (int i = 0; i < resourceArr.length(); i++) {
//                                    obj = resourceArr.getJSONObject(i);
                                    loginDetail.add(resourceArr.getJSONObject(i));
                                }*/
                                savePreferences.SavePreferences(getApplicationContext(), Constant.loginaccessTocken, 0);
                                Intent homeIntent = new Intent(HomeActivity.this, LoginActivity.class);
                                startActivity(homeIntent);
                                finish();
                            } else {
//                                Toast.makeText(getApplicationContext(), getResources().getString(R.string.toasttryagainmsg), Toast.LENGTH_SHORT).show();
                                showSnakBar(getResources().getString(R.string.toasttryagainmsg));
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }

                        hideProgressDialog();
                    }
                }, new Response.ErrorListener() {

            @Override
            public void onErrorResponse(VolleyError error) {
                // VolleyLog.d(TAG, "Error: " + error.getMessage());
                hideProgressDialog();
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

    private void showProgressDialog() {
        if (!progressBar.isShown())
            progressBar.setVisibility(View.VISIBLE);
    }

    private void hideProgressDialog() {
        if (progressBar.isShown())
            progressBar.setVisibility(View.INVISIBLE);
    }

    static class PagerAdapter extends FragmentPagerAdapter {
        private final List<Fragment> fragmentList = new ArrayList<>();
        private final List<String> fragmentTitleList = new ArrayList<>();

        public PagerAdapter(FragmentManager fragmentManager) {
            super(fragmentManager);
        }

        public void addFragment(Fragment fragment, String title) {
            fragmentList.add(fragment);
            fragmentTitleList.add(title);
        }

        @Override
        public Fragment getItem(int position) {
            return fragmentList.get(position);
        }

        @Override
        public int getCount() {
            return fragmentList.size();
        }

        @Override
        public CharSequence getPageTitle(int position) {
            return fragmentTitleList.get(position);
        }

    }
    private void calllogout(Activity context) {
        final Dialog dialog = new Dialog(context);
        //tell the Dialog to use the dialog.xml as it's layout description
        dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
        dialog.setContentView(R.layout.logout_customdialog);
        Button dialogButtonsave = (Button) dialog.findViewById(R.id.btn_save);
        Button dialogButtoncancel = (Button) dialog.findViewById(R.id.btn_cancel);

        dialogButtonsave.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                showProgressDialog();
                backendlogout(savePreferences.getPreferences_string(getApplicationContext(), Constant.loginid), "" + locationTracker.getLongitude(), "" + locationTracker.getLongitude());
//                postResolveStatus(userId, complain_id, complain_category_id, "" + locationTracker.getLatitude(), "" + locationTracker.getLongitude());
//                postResolveStatus(userId, complain_id,""+currentcatId,"" + locationTracker.getLatitude(), "" + locationTracker.getLongitude());
                dialog.dismiss();
            }
        });
        dialogButtoncancel.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                dialog.dismiss();
            }
        });
        dialog.setCanceledOnTouchOutside(true);
        if(!dialog.isShowing()){
            dialog.show();
        }
    }
    private void callkioskDialog(final Activity context) {
        final Dialog dialog = new Dialog(context);
        //tell the Dialog to use the dialog.xml as it's layout description
        dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
        dialog.setContentView(R.layout.logout_kioskdialog);
        Button dialogButtonsave = (Button) dialog.findViewById(R.id.btn_save);
        Button dialogButtoncancel = (Button) dialog.findViewById(R.id.btn_cancel);
        TextView dialogtitle= (TextView) dialog.findViewById(R.id.dialog_edit_inventory_txt_prodname);
        final EditText edit_pass= (EditText) dialog.findViewById(R.id.edit_pass);
        if(savePreferences.getPreferences_integer(context, Constant.Kios_Admin) < 1){
            dialogtitle.setText(getResources().getString(R.string.kiosk));
        }else{
            dialogtitle.setText(getResources().getString(R.string.kiosk_off));
        }
        dialogButtonsave.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(edit_pass.getText().toString().length()>0){
                    try {
                        if(Application.configdata.size()>0) {
//                        System.out.println("111 kiosk pass"+savePreferences.getPreferences_string(getApplicationContext(),Application.configdata.get(1).getString("name").toString()));
                            if (edit_pass.getText().toString().equalsIgnoreCase(savePreferences.getPreferences_string(getApplicationContext(), Application.configdata.get(0).getString("name").toString()))) {
//                        if(edit_pass.getText().toString().equalsIgnoreCase("kiosk@123")) {
                                if (savePreferences.getPreferences_integer(context, Constant.Kios_Admin) < 1) {
                                    savePreferences.SavePreferences(context, Constant.Kios_Admin, 1);
                                } else {
                                    savePreferences.SavePreferences(context, Constant.Kios_Admin, 0);
                                }

                                dialog.dismiss();
                            } else {
                                Toast.makeText(HomeActivity.this, getResources().getString(R.string.toastincorrectpass), Toast.LENGTH_SHORT).show();
//                            showSnakBar(getResources().getString(R.string.toastincorrectpass));
                            }
                        }
                        else {
                            Toast.makeText(HomeActivity.this, getResources().getString(R.string.toastincorrectpass), Toast.LENGTH_SHORT).show();
                        }
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
                else{
                    showSnakBar(getResources().getString(R.string.toastpasswordfillmsg));
                }
            }
        });
        dialogButtoncancel.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                dialog.dismiss();
            }
        });
        dialog.setCanceledOnTouchOutside(true);
        if(!dialog.isShowing()){
            dialog.show();
        }
    }
    private void callExit(Activity context) {
        final Dialog dialog = new Dialog(context);
        //tell the Dialog to use the dialog.xml as it's layout description
        dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
        dialog.setContentView(R.layout.exit_customdialog);
        Button dialogButtonsave = (Button) dialog.findViewById(R.id.btn_save);
        Button dialogButtoncancel = (Button) dialog.findViewById(R.id.btn_cancel);

        dialogButtonsave.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                HomeActivity.this.finish();
//                postResolveStatus(userId, complain_id, complain_category_id, "" + locationTracker.getLatitude(), "" + locationTracker.getLongitude());
//                postResolveStatus(userId, complain_id,""+currentcatId,"" + locationTracker.getLatitude(), "" + locationTracker.getLongitude());
                dialog.dismiss();
            }
        });
        dialogButtoncancel.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                dialog.dismiss();
            }
        });
        dialog.setCanceledOnTouchOutside(true);
        if(!dialog.isShowing()){
            dialog.show();
        }
    }

    @Override
    public void onBackPressed() {
//        super.onBackPressed();
//        callExit(HomeActivity.this);
    }
    public static void showSnakBar(String snakMsg) {
        Snackbar snackbar = Snackbar.make(coordinatorLayout,snakMsg, Snackbar.LENGTH_LONG);
        View snackBarView = snackbar.getView();
//        snackBarView.setBackgroundColor(getResources().getColor(R.color.colorAccent));
//        snackBarView.setBackgroundColor(Color.YELLOW);
        snackBarView.setBackgroundColor(Color.parseColor("#FFC000"));
        TextView tv = (TextView) snackBarView.findViewById(android.support.design.R.id.snackbar_text);
        tv.setTextColor(Color.BLACK);
//        snackBarView.setBackgroundColor(Color.parseColor("#DC3636"));
        snackbar.show();
    }
    private void getAllcategory() {
        Application.catlist.clear();
        JSONObject obj = new JSONObject();
        JsonObjectRequest jsonObjReq = new JsonObjectRequest(Request.Method.GET,
                Constant.bb_vandor_baseUrl + "getAllComplainCategory" , null,
                new Response.Listener<JSONObject>() {
                    @Override
                    public void onResponse(JSONObject response) {
                        try {
                            if (response.get("status_message").toString().equalsIgnoreCase("Success")) {
                                JSONArray resourceArr = response.getJSONArray("response");
                                for (int i = 0; i < resourceArr.length(); i++) {
                                    Category category = new Category();
                                    category.setName(resourceArr.getJSONObject(i).getString("desciption"));
                                    category.setId(resourceArr.getJSONObject(i).getString("complain_category_id"));
                                    category.setIsSelected(false);
                                    Application.catlist.add(category);
                                }
                                storeCategorytoDB(resourceArr);

                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }


                    }
                }, new Response.ErrorListener() {

            @Override
            public void onErrorResponse(VolleyError error) {

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

    private void storeCategorytoDB(JSONArray resourceArr) throws JSONException {
        DataSourceHandler db = DataSourceHandler.getInstance(HomeActivity.mainInstance);
        db.deleteAllCategoryData();
        for(int i=0;i<resourceArr.length();i++){
            Category category=new Category();
            category.setId(resourceArr.getJSONObject(i).get("complain_category_id").toString());
            category.setName(resourceArr.getJSONObject(i).get("desciption").toString());
            db.insertallCategoryData(category);
        }
    }

    private void killRunningApps() {
        List<ActivityManager.RunningAppProcessInfo> processes;
        ActivityManager amg;
        amg = (ActivityManager) getSystemService(ACTIVITY_SERVICE);
        processes = amg.getRunningAppProcesses();
        for (ActivityManager.RunningAppProcessInfo info : processes) {
            System.out.println("111 all running app"+info.processName);
            if (!info.processName.equalsIgnoreCase(
                    "de.example.android.kiosk")) {
                // kill selected process

                android.os.Process.killProcess(info.pid);
                android.os.Process.sendSignal(info.pid, android.os.Process.SIGNAL_KILL);
                amg.killBackgroundProcesses(info.processName);
                System.out.println("111 app kill" + info.pid);
            }
        }
    }

    @Override
    public void onWindowFocusChanged(boolean hasFocus) {
        super.onWindowFocusChanged(hasFocus);
        if(!hasFocus) {
            // Close every kind of system dialog
            Intent closeDialog = new Intent(Intent.ACTION_CLOSE_SYSTEM_DIALOGS);
            sendBroadcast(closeDialog);
        }
    }

//    @Override
//    public void onBackPressed() {
//        // nothing to do here
//        // … really
//    }
    @Override
    public boolean dispatchKeyEvent(KeyEvent event) {
        if (blockedKeys.contains(event.getKeyCode())) {
            return true;
        } else {
            return super.dispatchKeyEvent(event);
        }
    }
}
