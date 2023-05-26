import { Navigate, Outlet } from "react-router-dom";
import Login from "../pages/Auth/Login";
import Register from "../pages/Auth/Register";
const router = (isLoggedIn) => [
    // {// Private Routes
    //     path: '/',
    //     element: isLoggedIn ? <Outlet /> : <Navigate to="/login" />,
    //     children: [
    //         {
    //             path:'/',
    //             element: <Home />
    //         },
    //         {
    //             path: '/me',
    //             element: <Profile />
    //         }
    //     ]
    // },
    {
        path: '/',
        element: !isLoggedIn ? <Outlet /> : <Navigate to="/" />,
        children: [
            {
                path: '/login',
                element: <Login />
            },{
                path: '/register',
                element: <Register />
            }
        ]
    }
];

export default router;
