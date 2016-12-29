package com.hrpdss.android.listadapter;

import android.app.Activity;
import android.app.Dialog;
import android.content.Context;
import android.support.v4.app.FragmentActivity;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.LinearLayout;
import android.widget.RadioButton;
import android.widget.RelativeLayout;
import android.widget.TextView;

import com.hrpdss.android.R;
import com.hrpdss.android.Utility.OnLoadMoreListener;
import com.hrpdss.android.volley.Application;

/**
 * Created by Abhishek on 4/20/2016.
 */
public class ListDataAdapter extends RecyclerView.Adapter<ListDataAdapter.ProductLinearListHolder>{
    private final int VIEW_ITEM = 1;
    private final int VIEW_PROG = 0;
    private LayoutInflater layoutinflater;
    int listType;
    static Context context;
    static Activity activity;
    private int visibleThreshold = 5;
    private int lastVisibleItem, totalItemCount;
    private boolean loading;
    private OnLoadMoreListener onLoadMoreListener;
    Dialog dialog;


    public ListDataAdapter(Context context, FragmentActivity activity,int listtype, Dialog dialog) {
        this.layoutinflater = LayoutInflater.from(context);
        this.listType = listtype;
        this.context = context;
        this.activity=activity;
        this.dialog=dialog;
//        this.previouspos=previousPostion;
    }

    @Override
    public ProductLinearListHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = layoutinflater.inflate(R.layout.spinner_text, parent, false);
        ProductLinearListHolder viewHolder = new ProductLinearListHolder(view);
        context = parent.getContext();
        return viewHolder;
    }

    @Override
    public void onBindViewHolder(final ProductLinearListHolder holder, int position) {
//        try {
        final Category category= Application.catlist.get(position);

            holder.textView.setText(category.getName());
        if(category.isSelected){
            holder.button_radio.setChecked(true);
        }
        else{
            holder.button_radio.setChecked(false);
        }
           /* if(previouspos==position){
                System.out.println("111 previous pos"+previouspos);
                holder.button_radio.setChecked(true);
            }*/
          /* holder.item_spinner.setOnTouchListener(new View.OnTouchListener() {
                @Override
                public boolean onTouch(View v, MotionEvent event) {
                    holder.button_radio.setChecked(true);
                    category.setSelected(true);
                    return false;
                }
            });*/
//        holder.item_spinner.setOnClickListener(new View.OnClickListener() {
//            @Override
//            public void onClick(View v) {
//                holder.button_radio.setChecked(true);
////                category.setSelected(true);
//            }
//        });
//            holder.item_spinner.ont
//        } catch (JSONException e) {
//            e.printStackTrace();
//        }

    }

    @Override
    public int getItemCount() {
        return Application.catlist.size();
    }

    public static class ProductLinearListHolder extends RecyclerView.ViewHolder {


        RelativeLayout item_spinner;
        LinearLayout name,address;
        RadioButton button_radio;
        TextView textView;

        public ProductLinearListHolder(View itemView) {
            super(itemView);
            textView = (TextView) itemView.findViewById(R.id.textView);
            button_radio = (RadioButton) itemView.findViewById(R.id.button_radio);
            item_spinner= (RelativeLayout) itemView.findViewById(R.id.item_spinner);
//            textmobno= (TextView) itemView.findViewById(R.id.textmobno);
//            name= (LinearLayout) itemView.findViewById(R.id.name);
//            address= (LinearLayout) itemView.findViewById(R.id.address);

        }
    }
}