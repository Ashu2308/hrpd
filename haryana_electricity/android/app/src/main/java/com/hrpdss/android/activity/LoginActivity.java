package com.hrpdss.android.activity;

import android.Manifest;
import android.content.Intent;
import android.content.pm.PackageInfo;
import android.content.pm.PackageManager;
import android.graphics.Color;
import android.os.Bundle;
import android.support.design.widget.Snackbar;
import android.support.v4.app.ActivityCompat;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.AppCompatActivity;
import android.text.method.HideReturnsTransformationMethod;
import android.text.method.PasswordTransformationMethod;
import android.view.MotionEvent;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
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
import com.hrpdss.android.Utility.Utility;
import com.hrpdss.android.location.LocationTracker;
import com.hrpdss.android.storage.SavePreferences;
import com.hrpdss.android.volley.Application;
import com.hrpdss.android.volley.Constant;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

/**
 * Created by Namrata on 4/8/2016.
 */
public class LoginActivity extends AppCompatActivity {

    RelativeLayout rellayParent,login_img_eye;
    EditText txtUsername, txtPassword;
    ImageView imgPassword,img_eye;
    Button btnLogin;
    LocationTracker locationTracker;
    ProgressBar progressBar;
    SavePreferences savePreferences;
    private static final int PERMISSION_REQUEST_CODE = 0;
    boolean iseyeclick=false;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        initView();

        rellayParent.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View v, MotionEvent event) {
                Utility.hideKeyboard(getApplicationContext(), v);
                return false;
            }
        });

        btnLogin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                locationTracker = new LocationTracker(getApplicationContext());
                if(txtUsername.getText().toString().length()<1 && txtPassword.getText().toString().length()>0){
                    showSnakBar(rellayParent, getResources().getString(R.string.toastusernamefillmsg));
                }
                else if(txtUsername.getText().toString().length()>0 && txtPassword.getText().toString().length()<1){
                    showSnakBar(rellayParent, getResources().getString(R.string.toastpasswordfillmsg));
                }
                else if (txtUsername.getText().toString().length() > 0 && txtPassword.getText().toString().length() > 0) {
                    Utility.hideKeyboard(getApplicationContext(), v);
                    if (locationTracker.isConnectingToInternet()) {
                        if (locationTracker.canGetLocation()) {
                            Application.getInstance().trackEvent("Login", "Button_Click", "Login Screen");
                            sendloginDatatoBackend(txtUsername.getText().toString(), txtPassword.getText().toString(), "" + locationTracker.getLongitude(), "" + locationTracker.getLongitude(),""+getVersionCode());

                        } else {
//                            Toast.makeText(getApplicationContext(), getResources().getString(R.string.toastaddressmsg), Toast.LENGTH_SHORT).show();
//                            showSnakBar(rellayParent,getResources().getString(R.string.toastaddressmsg));
                            locationTracker.showSettingsAlert(LoginActivity.this);
                        }
                    } else {
//                        Toast.makeText(getApplicationContext(), getResources().getString(R.string.toastinternetmsg), Toast.LENGTH_SHORT).show();
                        showSnakBar(rellayParent, getResources().getString(R.string.toastinternetmsg));
                    }
                } else {
//                    Toast.makeText(getApplicationContext(), getResources().getString(R.string.toastusernamepassfillmsg), Toast.LENGTH_SHORT).show();
                    showSnakBar(rellayParent, getResources().getString(R.string.toastusernamepassfillmsg));
                }
            }
        });
        login_img_eye.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(iseyeclick==false) {
                    iseyeclick=true;
                    txtPassword.setTransformationMethod(HideReturnsTransformationMethod.getInstance());
                    txtPassword.setSelection(txtPassword.getText().length());
                    img_eye.setImageResource(R.mipmap.eye_cross);
                }
               else {
                    iseyeclick=false;
                    txtPassword.setTransformationMethod(PasswordTransformationMethod.getInstance());
                    txtPassword.setSelection(txtPassword.getText().length());
                    img_eye.setImageResource(R.mipmap.eye);
                }
            }
        });

    }

    private void initView() {
        progressBar = (ProgressBar) findViewById(R.id.progressbar);
        savePreferences=new SavePreferences();
        rellayParent = (RelativeLayout) findViewById(R.id.login_parent);
        login_img_eye= (RelativeLayout) findViewById(R.id.login_img_eye);
        img_eye= (ImageView) findViewById(R.id.img_eye);
        btnLogin = (Button) findViewById(R.id.login_btn_login);
        txtUsername = (EditText) findViewById(R.id.login_txt_uname);
        txtPassword = (EditText) findViewById(R.id.login_txt_pswrd);
        if (!checkPermission()) {
            requestPermission();
        }

    }
    private int getVersionCode() {
        PackageInfo pInfo = null;
        try {
            pInfo = getPackageManager().getPackageInfo(getPackageName(), 0);
        } catch (PackageManager.NameNotFoundException e) {
            e.printStackTrace();
        }
        String version = pInfo.versionName;
        int verCode = pInfo.versionCode;

        return verCode;
    }
    private void sendloginDatatoBackend(String userName, String password, String latitude, String longitude, String appVersion) {
        showProgressDialog();
        final ArrayList<JSONObject> loginDetail = new ArrayList<>();
        JSONObject obj = new JSONObject();
        System.out.println("111 logindetail"+Constant.bb_vandor_baseUrl + "getUserLogin/" + userName + "/" + password+"/"+latitude+"/"+longitude+"/"+appVersion);
        JsonObjectRequest jsonObjReq = new JsonObjectRequest(Request.Method.GET,
                Constant.bb_vandor_baseUrl + "getUserLogin/" + userName + "/" + password+"/"+latitude+"/"+longitude+"/"+appVersion, null,
                new Response.Listener<JSONObject>() {
                    @Override
                    public void onResponse(JSONObject response) {
                        try {
                            if (response.get("status_message").toString().equalsIgnoreCase("Login successful")) {
                                System.out.println("111 response"+response);
                                JSONArray resourceArr = response.getJSONArray("response");
//                                JSONObject obj = new JSONObject();
                                for (int i = 0; i < resourceArr.length(); i++) {
//                                    obj = resourceArr.getJSONObject(i);
                                    loginDetail.add(resourceArr.getJSONObject(i));
                                }
                                savePreferences.SavePreferences(getApplicationContext(),Constant.loginuserName,loginDetail.get(0).get("name").toString());
                                savePreferences.SavePreferences(getApplicationContext(),Constant.loginid,loginDetail.get(0).get("user_id").toString());
                                savePreferences.SavePreferences(getApplicationContext(),Constant.areaid,loginDetail.get(0).get("area_id").toString());
                                savePreferences.SavePreferences(getApplicationContext(),Constant.subdivision_id,loginDetail.get(0).get("subdivision_id").toString());
                                savePreferences.SavePreferences(getApplicationContext(),Constant.loginaccessTocken,1);
                                Intent homeIntent = new Intent(LoginActivity.this, HomeActivity.class);
                                startActivity(homeIntent);
                                finish();
                            } else if(response.get("status_message").toString().equalsIgnoreCase("You are not authorised to login.")){
//                                Toast.makeText(getApplicationContext(),getResources().getString(R.string.toastusernamepassincorrectmsg), Toast.LENGTH_SHORT).show();
                                showSnakBar(rellayParent,getResources().getString(R.string.toastnotauthorisedmsg));
                            }
                            else{
                                showSnakBar(rellayParent,getResources().getString(R.string.toastusernamepassincorrectmsg));
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
                showSnakBar(rellayParent, getResources().getString(R.string.toastusernamepassincorrectmsg));
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

    @Override
    protected void onResume() {
        super.onResume();
       Application.getInstance().trackScreenView("Login Screen");
    }

    private void showSnakBar(View view,String snakMsg) {
        Snackbar snackbar = Snackbar.make(view,snakMsg, Snackbar.LENGTH_LONG);
        View snackBarView = snackbar.getView();
//        snackBarView.setBackgroundColor(getResources().getColor(R.color.colorAccent));
        snackBarView.setBackgroundColor(Color.parseColor("#FFC000"));
        TextView tv = (TextView) snackBarView.findViewById(android.support.design.R.id.snackbar_text);
        tv.setTextColor(Color.BLACK);
        snackbar.show();
    }
    private boolean checkPermission() {
        int result = ContextCompat.checkSelfPermission(getApplicationContext(), Manifest.permission.READ_PHONE_STATE);
        if (result == PackageManager.PERMISSION_GRANTED) {
            return true;
        } else {
            return false;
        }
    }
    private void requestPermission() {
        if (ActivityCompat.shouldShowRequestPermissionRationale(this, Manifest.permission.READ_PHONE_STATE)) {
        } else {
            ActivityCompat.requestPermissions(this, new String[]{Manifest.permission.READ_PHONE_STATE, Manifest.permission.ACCESS_FINE_LOCATION, Manifest.permission.ACCESS_COARSE_LOCATION, Manifest.permission.CALL_PHONE}, PERMISSION_REQUEST_CODE);//
        }
    }


    @Override
    public void onRequestPermissionsResult(int requestCode, String permissions[], int[] grantResults) {
        switch (requestCode) {
            case PERMISSION_REQUEST_CODE:
                if (grantResults.length > 0 && grantResults[0] == PackageManager.PERMISSION_GRANTED) {
                }
                break;
        }
    }

}
