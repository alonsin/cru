import Swal from "sweetalert2";
import toastr from "toastr"

window.Swal = Swal; 

window.alertToast = function (data) {
	toastr[data.type](data.message, data.title ?? ""),
		(toastr.options = {
			closeButton: true,
			progressBar: true,
			timeOut: data.timeOut ?? "5000",
		});
};

window.addEventListener("alert", (event) => {
	alertToast(event.detail);
});
