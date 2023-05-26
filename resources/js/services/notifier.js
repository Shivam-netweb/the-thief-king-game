import { toast } from "react-toastify";

export function notify(Message, type = null){
    let callback = type == null ? toast : toast[type];
    const toastID = callback(Message,{
        position: "bottom-center",
        autoClose: 5000,
        closeOnClick: true,
        pauseOnClick: true,
        theme: 'light'
    });

    return toastID;
}

export function promiseNotify(promise,pendingText = "Requesting..."){
    toast.promise(
        promise,{
            pending: {
                render(){
                    return pendingText;
                }
            },
            success:{
                render(response) {
                    return response.message;
                }
            },
            error:{
                render(error){
                    return response.message
                }
            }
        }
    )
}
