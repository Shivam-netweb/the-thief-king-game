import { createSlice } from "@reduxjs/toolkit";
import axios from "axios";

const initAuth = JSON.parse(localStorage.getItem('auth') || "{}");

if(initAuth?.token != null){
    axios.defaults.headers.common['Authorization'] = `Bearer ${initAuth.token}`;
}

const authSlice = createSlice({
    name: "auth",
    initialState: {
        token: initAuth.token || null,
        id: initAuth.id || null
    },
    reducers: {
        setAuth: (state, action) => {
            if(action.payload.token && action.payload.id){
                state.id = action.payload.id;
                state.token = action.payload.token;
                // setting the values in localStorage
                localStorage.setItem('auth', JSON.stringify({token: action.payload.token, id: action.payload.id}));

                // Changing the headers of every requests
                axios.defaults.headers.common['Authorization'] = `Bearer ${action.payload.token}`;
            }
        },
        resetAuth: state => {
            state.id = null
            state.token = null;
            localStorage.removeItem('auth');
            axios.defaults.headers.common['Authorization'] = null;
        }
    }
});

export const {setAuth, resetAuth} = authSlice.actions;
export default authSlice.reducer;
