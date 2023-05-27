import React from "react";
import { useNavigate } from "react-router-dom";
import { RegisterNewUser } from "../../services/xhrHelper";
import { notify } from "../../services/notifier";
export default function Register() {
    const navigate = useNavigate();
    const handleSubmit = async (event) => {
        event.preventDefault();
        try {
            const response = await RegisterNewUser(new FormData(event.target));
            console.log(response);
            notify(response.data.message, response.data.type)
            navigate('/login');
        } catch (err) {
            let error = err.response.data;
            if (error.errors != undefined) {
                Object.keys(error.errors).map(
                    (input) =>
                        (event.target[input].nextElementSibling.innerText =
                            error.errors[input].join(", "))
                );
            } else {
                notify(error.message, "error");
            }
        }
    };
    return (
        <form onSubmit={handleSubmit}>
            <div><input type="text" name="first_name" placeholder="First Name" /><span className="error"></span></div>
            <div><input type="text" name="last_name" placeholder="Last Name" /><span className="error"></span></div>
            <div><input type="email" name="email" placeholder="email" /><span className="error"></span></div>
            <div><input type="password" name="password" placeholder="Password" /><span className="error"></span></div>
            <div><input type="password" name="password_confirmation" placeholder="Confirm Password" /><span className="error"></span></div>
            <button type="submit">Submit</button>
        </form>
    );
}
