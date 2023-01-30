var DatatableChildRemoteDataDemo = {
	init: function () {
		$(".m_datatable").mDatatable({
			data: {
				type: "remote",
				source: {
					read: {
						url: "https://keenthemes.com/metronic/preview/inc/api/datatables/demos/customers.php"
					}
				},
				pageSize: 10,
				serverPaging: !0,
				serverFiltering: !1,
				serverSorting: !0
			},
			layout: {
				theme: "default",
				scroll: !1,
				height: null,
				footer: !1
			},
			sortable: !0,
			pagination: !0,
			detail: {
				title: "Load sub table",
				content: function (t) {
					$("<div/>").attr("id", "child_data_ajax_" + t.data.RecordID).appendTo(t.detailCell).mDatatable({
						data: {
							type: "remote",
							source: {
								read: {
									url: "inc/api/datatables/demos/orders.php",
									headers: {
										"x-my-custom-header": "some value",
										"x-test-header": "the value"
									},
									params: {
										query: {
											generalSearch: "",
											CustomerID: t.data.RecordID
										}
									}
								}
							},
							pageSize: 10,
							serverPaging: !0,
							serverFiltering: !1,
							serverSorting: !0
						},
						layout: {
							theme: "default",
							scroll: !0,
							height: 300,
							footer: !1,
							spinner: {
								type: 1,
								theme: "default"
							}
						},
						sortable: !0,
						columns: [{
							field: "RecordID",
							title: "#",
							sortable: !1,
							width: 20,
							responsive: {
								hide: "xl"
							}
						}, {
							field: "OrderID",
							title: "Order ID",
							template: function (t) {
								return "<span>" + t.OrderID + " - " + t.ShipCountry + "</span>"
							}
						}, {
							field: "ShipCountry",
							title: "Country",
							width: 100
						}, {
							field: "ShipAddress",
							title: "Ship Address"
						}, {
							field: "ShipName",
							title: "Ship Name"
						}, {
							field: "TotalPayment",
							title: "Payment",
							type: "number"
						}, {
							field: "Status",
							title: "Status",
							template: function (t) {
								var e = {
									1: {
										title: "Pending",
										class: "m-badge--brand"
									},
									2: {
										title: "Delivered",
										class: " m-badge--metal"
									},
									3: {
										title: "Canceled",
										class: " m-badge--primary"
									},
									4: {
										title: "Success",
										class: " m-badge--success"
									},
									5: {
										title: "Info",
										class: " m-badge--info"
									},
									6: {
										title: "Danger",
										class: " m-badge--danger"
									},
									7: {
										title: "Warning",
										class: " m-badge--warning"
									}
								};
								return '<span class="m-badge ' + e[t.Status].class + ' m-badge--wide">' + e[t.Status].title + "</span>"
							}
						}, {
							field: "Type",
							title: "Type",
							template: function (t) {
								var e = {
									1: {
										title: "Online",
										state: "danger"
									},
									2: {
										title: "Retail",
										state: "primary"
									},
									3: {
										title: "Direct",
										state: "accent"
									}
								};
								return '<span class="m-badge m-badge--' + e[t.Type].state + ' m-badge--dot"></span> <span class="m--font-bold m--font-' + e[t.Type].state + '">' + e[t.Type].title + "</span>"
							}
						}]
					})
				}
			},
			search: {
				input: $("#generalSearch")
			},
			columns: [{
				field: "RecordID",
				title: "",
				sortable: !1,
				width: 20,
				textAlign: "center"
			}, {
				field: "checkbox",
				title: "",
				template: "{{RecordID}}",
				sortable: !1,
				width: 20,
				textAlign: "center",
				selector: {
					class: "m-checkbox--solid m-checkbox--brand"
				}
			}, {
				field: "FirstName",
				title: "First Name",
				sortable: "asc"
			}, {
				field: "LastName",
				title: "Last Name"
			}, {
				field: "Company",
				title: "Company"
			}, {
				field: "Email",
				title: "Email"
			}, {
				field: "Phone",
				title: "Phone"
			}, {
				field: "Status",
				title: "Status",
				template: function (t) {
					var e = {
						1: {
							title: "Pending",
							class: "m-badge--brand"
						},
						2: {
							title: "Delivered",
							class: " m-badge--metal"
						},
						3: {
							title: "Canceled",
							class: " m-badge--primary"
						},
						4: {
							title: "Success",
							class: " m-badge--success"
						},
						5: {
							title: "Info",
							class: " m-badge--info"
						},
						6: {
							title: "Danger",
							class: " m-badge--danger"
						},
						7: {
							title: "Warning",
							class: " m-badge--warning"
						}
					};
					return '<span class="m-badge ' + e[t.Status].class + ' m-badge--wide">' + e[t.Status].title + "</span>"
				}
			}, {
				field: "Type",
				title: "Type",
				template: function (t) {
					var e = {
						1: {
							title: "Online",
							state: "danger"
						},
						2: {
							title: "Retail",
							state: "primary"
						},
						3: {
							title: "Direct",
							state: "accent"
						}
					};
					return '<span class="m-badge m-badge--' + e[t.Type].state + ' m-badge--dot"></span> <span class="m--font-bold m--font-' + e[t.Type].state + '">' + e[t.Type].title + "</span>"
				}
			}, {
				field: "Actions",
				width: 110,
				title: "Actions",
				sortable: !1,
				overflow: "visible",
				template: function (t, e, a) {
					return '\t\t\t\t\t\t<div class="dropdown ' + (a.getPageSize() - e <= 4 ? "dropup" : "") + '">\t\t\t\t\t\t\t<a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown">                                <i class="la la-ellipsis-h"></i>                            </a>\t\t\t\t\t\t  \t<div class="dropdown-menu dropdown-menu-right">\t\t\t\t\t\t    \t<a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>\t\t\t\t\t\t    \t<a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>\t\t\t\t\t\t    \t<a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>\t\t\t\t\t\t  \t</div>\t\t\t\t\t\t</div>\t\t\t\t\t\t<a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">\t\t\t\t\t\t\t<i class="la la-edit"></i>\t\t\t\t\t\t</a>\t\t\t\t\t\t<a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">\t\t\t\t\t\t\t<i class="la la-trash"></i>\t\t\t\t\t\t</a>\t\t\t\t\t'
				}
			}]
		})
	}
};
jQuery(document).ready(function () {
	DatatableChildRemoteDataDemo.init()
});