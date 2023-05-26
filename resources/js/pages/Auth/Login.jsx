import React from "react";
import { notify } from "../../services/notifier";
import { loginUser } from "../../services/xhrHelper";
import { useNavigate } from "react-router-dom";
import { useSelector, useDispatch } from "react-redux";
export default function Login() {
    const navigate = useNavigate();
    const auth = useSelector(state => state.auth);
    const authDispatcher = useDispatch();

    const handleSubmit = async (event) => {
        try{
            var response = await loginUser(new FormData(event.target));
            if(response.data.status === 'success' && response.data.user != undefined){
                const tokenResponse = await generateAuthToken(response.data.user.id);
                if(tokenResponse.data.token != null){
                    authDispatcher(setAuth({token: tokenResponse.data.token, id: response.data.user.id}));
                    notify(response.data.message, response.data.status)
                    navigate('/');
                }
            }
        }catch(err){
            let error = err.response.data;
            if(error.errors != undefined){
                Object.keys(error.errors).map((input) => event.target[input].nextElementSibling.innerText = error.errors[input].join(', '));
            }else{
                notify(error.error, 'error');
            }
        }
    }
    return (
        <div>
            <form onSubmit={handleSubmit}>
                <input
                    type="text"
                    name="username"
                    placeholder="Enter UserName/Email/Phone"
                />
                <input
                    type="password"
                    name="password"
                    placeholder="Your password"
                />
                <button type="submit">Submit</button>
            </form>
        </div>
    );
}
