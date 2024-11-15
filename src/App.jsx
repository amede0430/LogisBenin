import { useContext } from "react";
import { Routes, Route, Navigate, useLocation, useNavigate } from "react-router-dom";
import { Navbar } from "@/widgets/layout";
import ProtectedRoute from "./pages/protected-route";
import { setupAxiosInterceptors } from "./services/interceptor";
import { AuthContext } from "@/context";
import routes from "@/routes";
import { Home, Profile, SignIn, SignUp } from "@/pages";


function App() {
  const { pathname } = useLocation();
  const authContext = useContext(AuthContext);
  const navigate = useNavigate();
  setupAxiosInterceptors(() => {
    authContext.logout();
    navigate("/sign-in");
  });

  return (
    <>
      {!(pathname == '/sign-in' || pathname == '/sign-up') && (
        <div className="container absolute left-2/4 z-10 mx-auto -translate-x-2/4 p-4">
          <Navbar routes={routes} />
        </div>
      )
      }
      <Routes>
      <Route path="/" element={<Navigate to="/home" />} />
      <Route path="/home" element={<Home />} />
      <Route path="/sign-in" element={<SignIn />} />
      <Route path="/sign-up" element={<SignUp />} />
        {routes.map(
          ({ path, element }, key) =>
            element && <Route key={key} exact path={path} element={
              <ProtectedRoute isAuthenticated={authContext.isAuthenticated}>
                {element}
              </ProtectedRoute>} />
        )}
        <Route path="*" element={<Navigate to="/home" replace />} />
      </Routes>
    </>
  );
}

export default App;


