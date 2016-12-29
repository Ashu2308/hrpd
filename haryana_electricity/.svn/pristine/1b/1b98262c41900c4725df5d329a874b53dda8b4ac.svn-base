package com.hrpdss.android.activity;

import android.Manifest;
import android.app.Activity;
import android.app.Dialog;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.graphics.Color;
import android.net.Uri;
import android.os.Bundle;
import android.support.design.widget.Snackbar;
import android.support.v4.app.ActivityCompat;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.CardView;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.Toolbar;
import android.util.DisplayMetrics;
import android.view.View;
import android.view.Window;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.ProgressBar;
import android.widget.RelativeLayout;
import android.widget.TextView;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.hrpdss.android.R;
import com.hrpdss.android.Utility.RecyclerItemClickListener;
import com.hrpdss.android.listadapter.Category;
import com.hrpdss.android.listadapter.ListDataAdapter;
import com.hrpdss.android.location.LocationTracker;
import com.hrpdss.android.storage.DataSourceHandler;
import com.hrpdss.android.storage.SavePreferences;
import com.hrpdss.android.volley.Application;
import com.hrpdss.android.volley.Constant;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

/**
 * Created by Abhishek on 4/11/2016.
 */
public class RequestDetailActivity extends AppCompatActivity{
    private Toolbar toolbar;
    private String username = "", screen = "", userId = "", complain_id = "",customer_id="",customer_name="",customer_address="",customer_phone="",complain_date="", complain_category_name = "",resolvedate="";
    private TextView navTitle,txt_category,lblcompaincategory,lblname,lblcustomerid,lbladdress,lblreporteddate,lblresolvedate,calltext;
    SavePreferences savePreferences;
    LocationTracker locationTracker;
    private ProgressBar pBar;
//    Spinner category_spinner;
    private ArrayList<String> catarr = new ArrayList<String>();
//    private ArrayList<JSONObject> catlist = new ArrayList<>();
    CardView card_pendingcategory;
    Button btn_resolved;
    int currentcatId = -1;
    RelativeLayout call_layout,logolayout,card_child_5,coordinatorLayout;
    private ListDataAdapter listDataAdapter;
    private DataSourceHandler db ;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_requestdetail);
        locationTracker=new LocationTracker(getApplicationContext());
        initViewPagerAndTabs();
        initView();
       /* if (screen.equalsIgnoreCase("pending")){
            getAllcategory();
        }*/
       /* dataAdapterAddressProof = new ArrayAdapter<String>(RequestDetailActivity.this, android.R.layout.simple_spinner_item, catarr);
        dataAdapterAddressProof.setDropDownViewResource(android.R.layout.select_dialog_singlechoice);*/

       /* category_spinner.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                Toast.makeText(getApplicationContext(), ""+position, Toast.LENGTH_LONG).show();
                if (position == 0) {
                    currentcatId = position;
                } else {
                    try {
                        currentcatId = getcomplainCatID(catlist, position);
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {
                currentcatId = -1;
            }
        });
*/
        btn_resolved.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                locationTracker=new LocationTracker(getApplicationContext());
                if (locationTracker.isConnectingToInternet() ){
                if(locationTracker.canGetLocation()) {
                    Application.getInstance().trackEvent("Resolved", "Button_Click", "Request Detail Screen");
                    if (currentcatId > -1) {
                        callresolveDialog(RequestDetailActivity.this);
                    } else {
//                        Toast.makeText(getApplicationContext(), getResources().getString(R.string.toastcategorymsg), Toast.LENGTH_SHORT).show();
                        showSnakBar(coordinatorLayout,getResources().getString(R.string.toastcategorymsg));

                    }
                }
                    else{
                    locationTracker.showSettingsAlert(RequestDetailActivity.this);
//                    showSnakBar(coordinatorLayout, getResources().getString(R.string.toastlocationmsg));
                }
                }
                else{
                    showSnakBar(coordinatorLayout,getResources().getString(R.string.toastinternetmsg));
                }

            }
        });

        call_layout.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                callDialog(RequestDetailActivity.this);
            }
        });

        card_pendingcategory.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                openListDialog();
            }
        });
    }
    private void callDialog(RequestDetailActivity requestDetailActivity) {
        final Dialog dialog = new Dialog(requestDetailActivity);
        //tell the Dialog to use the dialog.xml as it's layout description
        dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
        dialog.setContentView(R.layout.call_customdialog);
        Button dialogButtonsave = (Button) dialog.findViewById(R.id.btn_save);
        Button dialogButtoncancel = (Button) dialog.findViewById(R.id.btn_cancel);
        dialog.setCanceledOnTouchOutside(false);
        dialogButtonsave.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent callIntent = new Intent(Intent.ACTION_CALL);
                callIntent.setData(Uri.parse("tel:" + calltext.getText().toString().trim()));
                if (ActivityCompat.checkSelfPermission(RequestDetailActivity.this, Manifest.permission.CALL_PHONE) != PackageManager.PERMISSION_GRANTED) {
                    // TODO: Consider calling
                    //    ActivityCompat#requestPermissions
                    // here to request the missing permissions, and then overriding
                    //   public void onRequestPermissionsResult(int requestCode, String[] permissions,
                    //                                          int[] grantResults)
                    // to handle the case where the user grants the permission. See the documentation
                    // for ActivityCompat#requestPermissions for more details.
                    return;
                }
                startActivity(callIntent);
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

    private void callresolveDialog(Activity context) {
        final Dialog dialog = new Dialog(context);
        //tell the Dialog to use the dialog.xml as it's layout description
        dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
        dialog.setContentView(R.layout.resolve_customdialog);
        Button dialogButtonsave = (Button) dialog.findViewById(R.id.btn_save);
        Button dialogButtoncancel = (Button) dialog.findViewById(R.id.btn_cancel);
        dialog.setCanceledOnTouchOutside(true);
        dialogButtonsave.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
//                postResolveStatus(userId, complain_id, complain_category_id, "" + locationTracker.getLatitude(), "" + locationTracker.getLongitude());
                postResolveStatus(userId, complain_id, "" + currentcatId, "" + locationTracker.getLatitude(), "" + locationTracker.getLongitude());
                dialog.dismiss();
            }
        });
        dialogButtoncancel.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                dialog.dismiss();
            }
        });

        if(!dialog.isShowing()){
            dialog.show();
        }
    }
    @Override
    protected void onResume() {
        super.onResume();
        Application.getInstance().trackScreenView("Complain Detail Screen");
        if(!locationTracker.isConnectingToInternet()){
            getallOfflineCategoryList();
        }
    }

    private void getallOfflineCategoryList() {
        Application.catlist.clear();
        db = DataSourceHandler.getInstance(HomeActivity.mainInstance);
        List<Category> Dbcatlist=db.getAllCategoryDataObject();
        for (Category offlinelistdata : Dbcatlist) {

                Category category = new Category();
                category.setId(offlinelistdata.getId());
                category.setName(offlinelistdata.getName());
                category.setIsSelected(false);
                Application.catlist.add(category);


        }

    }

    private void postResolveStatus(String userId, String complain_id, String complain_category_id, String latitude, String longitude) {
        showProgressDialog();
        final ArrayList<JSONObject> loginDetail = new ArrayList<>();
        JSONObject obj = new JSONObject();
        System.out.println("111 resolveurl"+Constant.bb_vandor_baseUrl + "resolveComplain/" + userId + "/" + complain_id+ "/" + complain_category_id+"/"+latitude+"/"+longitude);
        JsonObjectRequest jsonObjReq = new JsonObjectRequest(Request.Method.GET,
                Constant.bb_vandor_baseUrl + "resolveComplain/" + userId + "/" + complain_id+ "/" + complain_category_id+"/"+latitude+"/"+longitude, null,
                new Response.Listener<JSONObject>() {
                    @Override
                    public void onResponse(JSONObject response) {
                        try {
                            System.out.println("111 res;ponse"+response);
                            if (response.get("status_message").toString().equalsIgnoreCase("success")) {
                               /* JSONArray resourceArr = response.getJSONArray("response");
//                                JSONObject obj = new JSONObject();
                                for (int i = 0; i < resourceArr.length(); i++) {
//                                    obj = resourceArr.getJSONObject(i);
                                    loginDetail.add(resourceArr.getJSONObject(i));
                                }
*/
                                RequestDetailActivity.this.finish();
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

    private void initView() {
        pBar = (ProgressBar) findViewById(R.id.pbar);
        coordinatorLayout= (RelativeLayout) findViewById(R.id.coordinatorLayout);
//        pBar.getIndeterminateDrawable().setColorFilter(Color.parseColor("#F7941D"), PorterDuff.Mode.SRC_IN);
        calltext= (TextView) findViewById(R.id.calltext);
        call_layout= (RelativeLayout) findViewById(R.id.call_layout);
        card_child_5= (RelativeLayout) findViewById(R.id.card_child_5);
        txt_category= (TextView) findViewById(R.id.txt_category);
//        category_spinner= (Spinner) findViewById(R.id.category_spinner);
        lblname= (TextView) findViewById(R.id.lblname);
        lblcustomerid= (TextView) findViewById(R.id.lblcustomerid);
        lbladdress= (TextView) findViewById(R.id.lbladdress);
        lblreporteddate= (TextView) findViewById(R.id.lblreporteddate);
        lblresolvedate= (TextView) findViewById(R.id.lblresolvedate);
        lblcompaincategory= (TextView) findViewById(R.id.lblcompaincategory);
        btn_resolved= (Button) findViewById(R.id.btn_resolved);
        savePreferences = new SavePreferences();

        username=savePreferences.getPreferences_string(getApplicationContext(), Constant.loginuserName);
        userId=savePreferences.getPreferences_string(getApplicationContext(), Constant.loginid);
        card_pendingcategory= (CardView) findViewById(R.id.card_pendingcategory);
        Intent dataIntent=getIntent();
        screen=dataIntent.getExtras().getString("screen");
        if(screen.equalsIgnoreCase("resolved")){
            complain_category_name=dataIntent.getExtras().getString("complain_category_name");
            resolvedate=dataIntent.getExtras().getString("resolve_date");
            lblcompaincategory.setText(complain_category_name);
            lblresolvedate.setText(resolvedate);
            card_child_5.setVisibility(View.VISIBLE);
            btn_resolved.setVisibility(View.INVISIBLE);
            card_pendingcategory.setVisibility(View.INVISIBLE);
        }
        complain_id=dataIntent.getExtras().getString("complain_id");
        customer_id=dataIntent.getExtras().getString("customer_id");
        customer_name=dataIntent.getExtras().getString("customer_name");
        customer_address=dataIntent.getExtras().getString("customer_address");
        customer_phone=dataIntent.getExtras().getString("customer_phone");
        complain_date=dataIntent.getExtras().getString("complain_date");
        lblname.setText(customer_name);
        calltext.setText(customer_phone);
        lbladdress.setText(customer_address);
        lblcustomerid.setText(customer_id);
        lblreporteddate.setText(complain_date);
        navTitle.setText(customer_name);

    }

    private void initViewPagerAndTabs() {

        toolbar = (Toolbar) findViewById(R.id.toolbar);
        toolbar.setNavigationIcon(R.mipmap.back);
        navTitle = (TextView) toolbar.findViewById(R.id.toolbar_title);
//        rellayNavMenu = (RelativeLayout) toolbar.findViewById(R.id.nav_rellay_menu);
        logolayout= (RelativeLayout) toolbar.findViewById(R.id.logolayout);
        setSupportActionBar(toolbar);
        getSupportActionBar().setDisplayShowHomeEnabled(false);
        getSupportActionBar().setDisplayHomeAsUpEnabled(false);
        getSupportActionBar().setDisplayShowTitleEnabled(false);

        ImageView back= (ImageView) toolbar.findViewById(R.id.logo);
        logolayout.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onBackPressed();
            }
        });
        /*navTitle.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onBackPressed();
            }
        });*/
        /*toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onBackPressed();
            }
        });*/



    }

    private void showProgressDialog() {
        if (!pBar.isShown())
            pBar.setVisibility(View.VISIBLE);
    }

    private void hideProgressDialog() {
        if (pBar.isShown())
            pBar.setVisibility(View.INVISIBLE);
    }
    private int getcomplainCatID(ArrayList<JSONObject> catlist, int position) throws JSONException {
        int id ;
        id = catlist.get(position).getInt("complain_category_id");

        return id;
    }


    private void openListDialog() {
        // custom dialog
        final Dialog dialog = new Dialog(RequestDetailActivity.this);
        DisplayMetrics metrics = getResources().getDisplayMetrics();
        int width = metrics.widthPixels;
        int height = metrics.heightPixels;
        dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
        dialog.setContentView(R.layout.dialog_popup);
        dialog.getWindow().setLayout((6 * width) / 6, RelativeLayout.LayoutParams.WRAP_CONTENT);
        dialog.setCanceledOnTouchOutside(false);

        RecyclerView listPopup = (RecyclerView) dialog.findViewById(R.id.list_popup);
        listPopup.addOnItemTouchListener(new RecyclerItemClickListener(RequestDetailActivity.this, new RecyclerItemClickListener.OnItemClickListener() {
                    @Override
                    public void onItemClick(View view, int position) {
                            currentcatId=Integer.parseInt(Application.catlist.get(position).getId());
                            txt_category.setText(Application.catlist.get(position).getName());
                        setfalseRadio("" + currentcatId);
                        System.out.println("111 id" + currentcatId);

                        dialog.dismiss();

                    }
                })
        );

        listPopup.setLayoutManager(new LinearLayoutManager(this));

        listDataAdapter = new ListDataAdapter(getApplicationContext(),RequestDetailActivity.this,1,dialog);
        listPopup.setAdapter(listDataAdapter);

        dialog.show();
    }

    private void setfalseRadio(String position) {
        for(int i=0;i<Application.catlist.size();i++){
            if(Application.catlist.get(i).getId().equalsIgnoreCase(position)) {
                Category category = Application.catlist.get(i);
                category.setIsSelected(true);

            }
            else{
                Category category = Application.catlist.get(i);

                category.setIsSelected(false);
            }

        }

    }

    protected void showSnakBar(View view,String snakMsg) {
        Snackbar snackbar = Snackbar.make(view,snakMsg, Snackbar.LENGTH_LONG);
        View snackBarView = snackbar.getView();
//        snackBarView.setBackgroundColor(getResources().getColor(R.color.colorAccent));
        snackBarView.setBackgroundColor(Color.parseColor("#FFC000"));
        TextView tv = (TextView) snackBarView.findViewById(android.support.design.R.id.snackbar_text);
        tv.setTextColor(Color.BLACK);
        snackbar.show();
    }
}
