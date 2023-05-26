import { configureStore } from "@reduxjs/toolkit";
import AuthReducer from "./AuthReducer";

export const stores = configureStore({
    reducer:{
        'auth': AuthReducer
    }
});
