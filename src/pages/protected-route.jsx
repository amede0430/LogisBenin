import { Navigate } from "react-router-dom";

const ProtectedRoute = ({ isAuthenticated, redirectPath = "/sign-in", children }) => {

  if (!isAuthenticated) {
    return <Navigate to={redirectPath} replace />;
  }

  return children;
};

export default ProtectedRoute;
