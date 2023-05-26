import './bootstrap';
import React from "react";
import ReactDOM from "react-dom/client";
import { BrowserRouter, useRoutes } from "react-router-dom";
import router from "./routes/index";
import { ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import { Provider, useSelector } from "react-redux";
import { stores } from "./stores/RegisterStores";

const root = ReactDOM.createRoot(document.getElementById("app"));

function App() {
    const auth = useSelector((state) => state.auth);
    const routing = useRoutes(router(auth.token != null ? true : false));
    return routing;
}

root.render(
    <React.StrictMode>
        <Provider store={stores}>
            <BrowserRouter>
                <App />
            </BrowserRouter>
            <ToastContainer />
        </Provider>
    </React.StrictMode>
);
