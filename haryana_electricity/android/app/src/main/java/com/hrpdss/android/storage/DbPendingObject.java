package com.hrpdss.android.storage;

/**
 * Created by Abhishek on 4/21/2016.
 */
public class DbPendingObject {
	private long rowid;
//	private long date;
	private String customerName;
	private String customerMobnumber;
	private String customerId;
	private String complainId;
	private String customerAddress;
	private String reportedDate;
	private String resolveDate;


	public long getRowid() {
		return rowid;
	}

	public void setRowid(long rowid) {
		this.rowid = rowid;
	}
	/*public long getDate() {
		return date;
	}
	public void setDate(long date) {
		this.date = date;
	}*/
	public String getCustomerName() {
		return customerName;
	}

	public void setCustomerName(String customerName) {
		this.customerName = customerName;
	}

	public String getCustomerMobnumber() {
		return customerMobnumber;
	}

	public void setCustomerMobnumber(String customerMobnumber) {
		this.customerMobnumber = customerMobnumber;
	}

	public String getCustomerId() {
		return customerId;
	}

	public void setCustomerId(String customerId) {
		this.customerId = customerId;
	}
	public String getComplainId() {
		return complainId;
	}

	public void setComplainId(String complainId) {
		this.complainId = complainId;
	}

	public String getCustomerAddress() {
		return customerAddress;
	}

	public void setCustomerAddress(String customerAddress) {
		this.customerAddress = customerAddress;
	}

	public String getReportedDate() {
		return reportedDate;
	}

	public void setReportedDate(String reportedDate) {
		this.reportedDate = reportedDate;
	}

	public String getResolveDate() {
		return resolveDate;
	}

	public void setResolveDate(String resolveDate) {
		this.resolveDate = resolveDate;
	}


}
