package com.hrpdss.android.listadapter;

import android.Manifest;
import android.app.Activity;
import android.app.Dialog;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.net.Uri;
import android.support.v4.app.ActivityCompat;
import android.support.v4.app.FragmentActivity;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.hrpdss.android.R;
import com.hrpdss.android.activity.RequestDetailActivity;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

/**
 * Created by Namrata on 3/17/2016.
 */
public class RequestAdapter extends RecyclerView.Adapter<RequestAdapter.ProductLinearListHolder> {

    private LayoutInflater layoutinflater;
    static Context context;
    static Activity activity;
    int quantity = 1;
    int listType;
    ArrayList<JSONObject> arrPendingRequests;
    String screen="";


    public RequestAdapter(Context context, FragmentActivity activity, ArrayList<JSONObject> arpendings, int listtype, String pending) {
        this.layoutinflater = LayoutInflater.from(context);
        this.listType = listtype;
        this.arrPendingRequests=arpendings;
        this.context = context;
        this.activity=activity;
        this.screen=pending;
    }

    /*public ProductbabycareLinearListAdapter(Context context, List<JSONObject> productlistArr) {
        this.layoutinflater = LayoutInflater.from(context);
        this.productlistArr = productlistArr;
        this.context = context;
    }*/

    @Override
    public ProductLinearListHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = layoutinflater.inflate(R.layout.list_adapter_pending, parent, false);
        ProductLinearListHolder viewHolder = new ProductLinearListHolder(view);
        context = parent.getContext();
        return viewHolder;
    }

    @Override
    public void onBindViewHolder(final ProductLinearListHolder holder, final int position) {
        try {
            holder.lblname.setText(arrPendingRequests.get(position).get("customer_name").toString());
            holder.lbladdress.setText(arrPendingRequests.get(position).get("customer_address").toString());
            holder.textmobno.setText(arrPendingRequests.get(position).get("customer_mobile").toString());
        } catch (JSONException e) {
            e.printStackTrace();
        }
        holder.calling.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                callDialog(activity,holder.textmobno);
            }
        });
        holder.name.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(arrPendingRequests.size()>0){
                Intent intent = new Intent(activity, RequestDetailActivity.class);
                intent.putExtra("screen",screen);
                try {
                    if(screen.equalsIgnoreCase("resolved")){
                        intent.putExtra("complain_category_name",arrPendingRequests.get(position).get("complain_category_name").toString());
                        intent.putExtra("resolve_date",arrPendingRequests.get(position).get("resolve_date").toString());
                    }
                    intent.putExtra("complain_id",arrPendingRequests.get(position).get("complain_id").toString());
                    intent.putExtra("customer_id",arrPendingRequests.get(position).get("customer_id").toString());
                    intent.putExtra("customer_name",arrPendingRequests.get(position).get("customer_name").toString());
                    intent.putExtra("customer_address", arrPendingRequests.get(position).get("customer_address").toString());
                    intent.putExtra("customer_phone",arrPendingRequests.get(position).get("customer_mobile").toString());
                    intent.putExtra("complain_date", arrPendingRequests.get(position).get("complain_date").toString());

                } catch (JSONException e) {
                    e.printStackTrace();
                }
                activity.startActivity(intent);
            }
            }

        });
        holder.address.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                System.out.println("111 offline data at click address"+arrPendingRequests);
                if (arrPendingRequests.size() > 0) {
                    Intent intent = new Intent(activity, RequestDetailActivity.class);
                    intent.putExtra("screen", screen);
                    try {
                        if (screen.equalsIgnoreCase("resolved")) {
                            intent.putExtra("complain_category_name", arrPendingRequests.get(position).get("complain_category_name").toString());
                            intent.putExtra("resolve_date", arrPendingRequests.get(position).get("resolve_date").toString());
                        }
                        intent.putExtra("complain_id", arrPendingRequests.get(position).get("complain_id").toString());
                        intent.putExtra("customer_id", arrPendingRequests.get(position).get("customer_id").toString());
                        intent.putExtra("customer_name", arrPendingRequests.get(position).get("customer_name").toString());
                        intent.putExtra("customer_address", arrPendingRequests.get(position).get("customer_address").toString());
                        intent.putExtra("customer_phone", arrPendingRequests.get(position).get("customer_mobile").toString());
                        intent.putExtra("complain_date", arrPendingRequests.get(position).get("complain_date").toString());
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                    activity.startActivity(intent);
                }
            }
        });

    }

    private void callDialog(Activity requestDetailActivity, final TextView textmobno) {
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
                callIntent.setData(Uri.parse("tel:" + textmobno.getText().toString().trim()));
                if (ActivityCompat.checkSelfPermission(context, Manifest.permission.CALL_PHONE) != PackageManager.PERMISSION_GRANTED) {
                    // TODO: Consider calling
                    //    ActivityCompat#requestPermissions
                    // here to request the missing permissions, and then overriding
                    //   public void onRequestPermissionsResult(int requestCode, String[] permissions,
                    //                                          int[] grantResults)
                    // to handle the case where the user grants the permission. See the documentation
                    // for ActivityCompat#requestPermissions for more details.
                    return;
                }
                context.startActivity(callIntent);
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
    public static class ProductLinearListHolder extends RecyclerView.ViewHolder {


        LinearLayout calling;
        LinearLayout name,address;
        TextView textmobno,lblname,lbladdress;

        public ProductLinearListHolder(View itemView) {
            super(itemView);
//            txtProductName = (TextView) itemView.findViewById(R.id.product_Item_name);
            calling= (LinearLayout) itemView.findViewById(R.id.calling);
            textmobno= (TextView) itemView.findViewById(R.id.textmobno);
            name= (LinearLayout) itemView.findViewById(R.id.name);
            address= (LinearLayout) itemView.findViewById(R.id.address);
            lblname= (TextView) itemView.findViewById(R.id.lblname);
            lbladdress= (TextView) itemView.findViewById(R.id.lbladdress);

        }
    }


    @Override
    public int getItemCount() {
        return arrPendingRequests.size();

    }


}