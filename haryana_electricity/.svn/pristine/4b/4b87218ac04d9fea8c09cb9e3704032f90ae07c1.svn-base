package com.hrpdss.android.fragment;

import android.os.Bundle;
import android.support.v4.app.Fragment;
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
 * Created by Abhishek on 4/8/2016.
 */
public class FragmentResolved extends Fragment {
    RecyclerView listResolvedRequests;
    RequestAdapter mAdapter;
    ArrayList<JSONObject> arrResolveRequests = new ArrayList<>();
    ProgressBar progressBar;
    SavePreferences savePreferences;
    TextView textView;
    LocationTracker locationTracker;
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {

        // Inflate the layout for this fragment
        View root = inflater.inflate(R.layout.fragment_resolved, container, false);
        locationTracker=new LocationTracker(getActivity().getApplicationContext());
        initView(root);

        listResolvedRequests.setAdapter(mAdapter);

        // test item long click
        listResolvedRequests.addOnItemTouchListener(new RecyclerItemClickListener(getContext(), new RecyclerItemClickListener.OnItemClickListener() {
                    @Override
                    public void onItemClick(View view, int position) {
                        Application.getInstance().trackEvent("Resolve List", "Button_Click", "Resolve List Screen");
//                        Intent intent = new Intent(getActivity(), RequestDetailActivity.class);
//                        intent.putExtra("screen","resolved");
//                        getActivity().startActivity(intent);


                    }
                })
        );

        return root;
    }

    private void initView(View root) {
        listResolvedRequests = (RecyclerView) root.findViewById(R.id.listView_resolved);
        textView= (TextView) root.findViewById(R.id.textView);
        progressBar = (ProgressBar) root.findViewById(R.id.pbar);
        mAdapter = new RequestAdapter(getContext(), getActivity(), arrResolveRequests, 1, "resolved");
        listResolvedRequests.setHasFixedSize(true);
        LinearLayoutManager layoutManager = new LinearLayoutManager(getActivity());
        listResolvedRequests.setLayoutManager(layoutManager);
        savePreferences=new SavePreferences();
    }

    @Override
    public void onResume() {
        super.onResume();
        loadResolveRequests();
        Application.getInstance().trackScreenView("Resolve List Screen");
    }

    private void loadResolveRequests() {
        if(!locationTracker.isConnectingToInternet()){
            HomeActivity.showSnakBar(getResources().getString(R.string.toastinternetmsg));
        }
        showProgressDialog();
//        final ArrayList<JSONObject> pendingListArr = new ArrayList<>();

        JSONObject obj = new JSONObject();
        JsonObjectRequest jsonObjReq = new JsonObjectRequest(Request.Method.GET,
                Constant.bb_vandor_baseUrl + "getAllResolvedComplain/" + savePreferences.getPreferences_string(getActivity().getApplicationContext(), Constant.subdivision_id)+"/"+savePreferences.getPreferences_string(getActivity().getApplicationContext(),Constant.loginid) , null,
                new Response.Listener<JSONObject>() {
                    @Override
                    public void onResponse(JSONObject response) {
                        try {
                            arrResolveRequests.clear();
                            if (response.get("status_message").toString().equalsIgnoreCase("success")) {
                                JSONArray resourceArr = response.getJSONArray("response");
//                                JSONObject obj = new JSONObject();
                                for (int i = 0; i < resourceArr.length(); i++) {
//                                    obj = resourceArr.getJSONObject(i);
//                                    System.out.println("111 resourceArr resolve"+resourceArr);
                                    arrResolveRequests.add(resourceArr.getJSONObject(i));
                                }
                                if(arrResolveRequests.size()==0){
                                    textView.setVisibility(View.VISIBLE);
                                }
                                else{
                                    textView.setVisibility(View.GONE);
                                }
                                listResolvedRequests.setAdapter(mAdapter);
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
}
