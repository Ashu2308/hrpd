package com.hrpdss.android.fragment;

import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.content.LocalBroadcastManager;
import android.support.v7.widget.CardView;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ProgressBar;
import android.widget.TextView;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.hrpdss.android.R;
import com.hrpdss.android.Utility.RecyclerItemClickListener;
import com.hrpdss.android.activity.HomeActivity;
import com.hrpdss.android.listadapter.RequestAdapter;
import com.hrpdss.android.location.LocationTracker;
import com.hrpdss.android.storage.DataSourceHandler;
import com.hrpdss.android.storage.DbPendingObject;
import com.hrpdss.android.storage.SavePreferences;
import com.hrpdss.android.volley.Application;
import com.hrpdss.android.volley.Constant;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

/**
 * Created by Avhishek on 4/11/2016.
 */
public class FragmentPending extends Fragment {

    private RecyclerView listPendingRequests;
    private RequestAdapter mAdapter;
    private ArrayList<JSONObject> arrPendingRequests = new ArrayList<>();
    private List<DbPendingObject> Dbpendinglist ;
    private ProgressBar progressBar;
    private SavePreferences savePreferences;
    private TextView textView;
    private CardView card_internet;
    private LocationTracker locationTracker;
    private DataSourceHandler db ;
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {

        // Inflate the layout for this fragment
        View root = inflater.inflate(R.layout.fragment_pending, container, false);
        locationTracker=new LocationTracker(getActivity().getApplicationContext());
        initView(root);

        // test item long click
        listPendingRequests.addOnItemTouchListener(new RecyclerItemClickListener(getContext(), new RecyclerItemClickListener.OnItemClickListener() {
                    @Override
                    public void onItemClick(View view, int position) {
                        Application.getInstance().trackEvent("Pending List", "Button_Click", "Pending List Screen");


                    }
                })
        );
       /* if(!locationTracker.isConnectingToInternet()){
            card_internet.setVisibility(View.VISIBLE);
        }
        else{
            card_internet.setVisibility(View.GONE);
        }*/

        return root;
    }

    @Override
    public void onResume() {
        super.onResume();
       /* if(!locationTracker.isConnectingToInternet()){
            card_internet.setVisibility(View.VISIBLE);
        }
        else{
            card_internet.setVisibility(View.GONE);
        }*/
        loadPendingRequests();
        Application.getInstance().trackScreenView("Pending List Screen");
        LocalBroadcastManager.getInstance(getActivity()).registerReceiver(mMessageReceiver, new IntentFilter("NOTIFICATION_RECEIVED"));
    }

    @Override
    public void onPause() {
        super.onPause();
        LocalBroadcastManager.getInstance(getActivity()).unregisterReceiver(mMessageReceiver);
    }

    private BroadcastReceiver mMessageReceiver = new BroadcastReceiver() {
        @Override
        public void onReceive(Context context, Intent intent) {
            loadPendingRequests();
//			Bundle extras = intent.getExtras();
           /* if(sharedpref.getPreferences_integer(context,"ntcount")>1){
                notification_layout.setVisibility(View.VISIBLE);
                txt_count.setText(""+(sharedpref.getPreferences_integer(context,"ntcount")-1));
            }*/
        }

    };
    private void initView(View root) {
        listPendingRequests = (RecyclerView) root.findViewById(R.id.listView_pending);
        textView= (TextView) root.findViewById(R.id.textView);
        card_internet= (CardView) root.findViewById(R.id.card_internet);
        progressBar = (ProgressBar) root.findViewById(R.id.pbar);
        mAdapter = new RequestAdapter(getContext(),getActivity(),arrPendingRequests, 1,"pending");
        listPendingRequests.setHasFixedSize(true);
        LinearLayoutManager layoutManager = new LinearLayoutManager(getActivity());
        listPendingRequests.setLayoutManager(layoutManager);
        listPendingRequests.setAdapter(mAdapter);
        savePreferences=new SavePreferences();
    }


    private void loadPendingRequests() {
        db = DataSourceHandler.getInstance(HomeActivity.mainInstance);
        if(!locationTracker.isConnectingToInternet()){
            HomeActivity.showSnakBar(getResources().getString(R.string.toastinternetmsg));
            getallDbPendingList();
        }
        else {
            showProgressDialog();
            arrPendingRequests.clear();
            JSONObject obj = new JSONObject();
            JsonObjectRequest jsonObjReq = new JsonObjectRequest(Request.Method.GET,
                    Constant.bb_vandor_baseUrl + "getAllPendingComplain/" + savePreferences.getPreferences_string(getActivity().getApplicationContext(), Constant.subdivision_id)+"/"+savePreferences.getPreferences_string(getActivity().getApplicationContext(),Constant.loginid), null,
                    new Response.Listener<JSONObject>() {
                        @Override
                        public void onResponse(JSONObject response) {
                            try {
                                if (response.get("status_message").toString().equalsIgnoreCase("success")) {
                                    JSONArray resourceArr = response.getJSONArray("response");
//                                JSONObject obj = new JSONObject();
                                    for (int i = 0; i < resourceArr.length(); i++) {
//                                    obj = resourceArr.getJSONObject(i);
                                        arrPendingRequests.add(resourceArr.getJSONObject(i));
                                    }
                                    showCount(arrPendingRequests);

                                    listPendingRequests.setAdapter(mAdapter);
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
    }
    private void showProgressDialog() {
        if (!progressBar.isShown())
            progressBar.setVisibility(View.VISIBLE);
    }

    private void hideProgressDialog() {
        if (progressBar.isShown())
            progressBar.setVisibility(View.INVISIBLE);
    }


    private void showCount(ArrayList<JSONObject> arrPendingRequests) {
        if(arrPendingRequests.size()>0){
            HomeActivity.textViewcount.setText("("+arrPendingRequests.size()+")");
            textView.setVisibility(View.GONE);}
        else{
            HomeActivity.textViewcount.setText("");
            textView.setVisibility(View.VISIBLE);
        }
        try {
            storePendingListinDb(arrPendingRequests);
        } catch (JSONException e) {
            e.printStackTrace();
        }
    }

    private void storePendingListinDb(ArrayList<JSONObject> arrPendingRequests) throws JSONException {
        db.deleteAllPendingListData();
//        db.delete(TABLE_NAME, null, null);
        for(int i=0;i<arrPendingRequests.size();i++){
            DbPendingObject obj=new DbPendingObject();
            obj.setCustomerName(arrPendingRequests.get(i).get("customer_name").toString());
            obj.setCustomerId(arrPendingRequests.get(i).get("customer_id").toString());
            obj.setComplainId(arrPendingRequests.get(i).get("complain_id").toString());
            obj.setCustomerMobnumber(arrPendingRequests.get(i).get("customer_mobile").toString());
            obj.setCustomerAddress(arrPendingRequests.get(i).get("customer_address").toString());
            obj.setReportedDate(arrPendingRequests.get(i).get("complain_date").toString());
            obj.setResolveDate("");
            db.insertintoLINEMANPENDINGLIST(obj);
        }
    }


    private void getallDbPendingList(){
        arrPendingRequests.clear();
        List<DbPendingObject> Dbpendinglist=db.getAllLINEMANPENDINGLIST();
        for (DbPendingObject offlinelistdata : Dbpendinglist) {
            JSONObject obj=new JSONObject();
            try {
                obj.put("customer_name", offlinelistdata.getCustomerName());
                obj.put("customer_id",offlinelistdata.getCustomerId());
                obj.put("complain_id",offlinelistdata.getComplainId());
            obj.put("customer_address",offlinelistdata.getCustomerAddress());
            obj.put("customer_phone",offlinelistdata.getCustomerMobnumber());
            obj.put("complain_date", offlinelistdata.getReportedDate());
            arrPendingRequests.add(obj);
            } catch (JSONException e) {
                e.printStackTrace();
            }

        }
        System.out.println("111 offline arraylist"+arrPendingRequests);
        mAdapter = new RequestAdapter(getContext(),getActivity(),arrPendingRequests, 1,"pending");
        listPendingRequests.setHasFixedSize(true);
        LinearLayoutManager layoutManager = new LinearLayoutManager(getActivity());
        listPendingRequests.setLayoutManager(layoutManager);
        listPendingRequests.setAdapter(mAdapter);

    }
}
