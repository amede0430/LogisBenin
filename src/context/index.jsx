import { createContext, useState, useEffect } from "react";
import { useLocation, useNavigate } from "react-router-dom";

export const AuthContext = createContext({
  role: null,
  isAuthenticated: false,
  login: () => {},
  register: () => {},
  logout: () => {},
});

const AuthContextProvider = ({ children }) => {
  const [isAuthenticated, setIsAuthenticated] = useState(false);
  const [role, setRole] = useState(() => localStorage.getItem("role") || null);

  const navigate = useNavigate();
  const location = useLocation();

  const token = localStorage.getItem("token");

  useEffect(() => {
    const isPublicRoute = location.pathname.startsWith("/auth/") || location.pathname.startsWith("/public/");
    if (!token && !localStorage.getItem("role") && !isPublicRoute) {
      navigate("/auth/login");
      return;
    }
    
    setRole(localStorage.getItem("role"))
    setIsAuthenticated(true);
    navigate(location.pathname); 
  }, [token, isAuthenticated, navigate, location.pathname]);
  

  const login = (token, userRole) => {
    localStorage.setItem("token", token);
    localStorage.setItem("role", userRole);
    setRole(userRole)
    setIsAuthenticated(true);
    if(role === "admin"){
      navigate("/gestion-ecoles");
    } else if(role === "ecole"){
      navigate("/mes-classes");
    }
  };

  const register = () => {
    navigate("/auth/login")
  }

  const logout = () => {
    localStorage.removeItem("token");
    localStorage.removeItem("role");
    setIsAuthenticated(false);
    setRole(null)
    navigate("/auth/login");
  };

  return (
    <AuthContext.Provider value={{ isAuthenticated, role, login, logout, register }}>
      {children}
    </AuthContext.Provider>
  );
};





export {
    AuthContextProvider,
  };