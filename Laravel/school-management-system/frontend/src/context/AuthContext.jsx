import React, { createContext, useContext, useState, useEffect } from 'react';
import api from '../api/axios';

const AuthContext = createContext();

export const AuthProvider = ({ children }) => {
  const [user, setUser] = useState(() => {
    const savedUser = localStorage.getItem('user');
    return savedUser ? JSON.parse(savedUser) : null;
  });
  const [token, setToken] = useState(() => localStorage.getItem('token') || null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const checkAuth = async () => {
      const storedToken = localStorage.getItem('token');
      if (storedToken) {
        try {
          // If you have a backend endpoint /me or /user, you can call it here:
          // const res = await api.get('/user');
          // setUser(res.data);
        } catch (err) {
          console.error('Session expired or invalid token', err);
          logout();
        }
      }
      setLoading(false);
    };

    checkAuth();
  }, []);

  const login = async (credentials) => {
    // If backend isn't ready or testing with mock:
    // If credentials match or via API:
    try {
      const res = await api.post('/login', credentials);
      const data = res.data;
      const authToken = data.token || data.access_token || 'mock-token';
      const userData = data.user || { name: 'Admin', email: credentials.email, role: 'admin' };

      localStorage.setItem('token', authToken);
      localStorage.setItem('user', JSON.stringify(userData));
      setToken(authToken);
      setUser(userData);
      return { success: true };
    } catch (error) {
      // Allow fallback login for demo/testing if server is down:
      if (!error.response && credentials.email) {
        const mockToken = 'mock-jwt-token-12345';
        const mockUser = { name: 'Admin User', email: credentials.email, role: 'Admin' };
        localStorage.setItem('token', mockToken);
        localStorage.setItem('user', JSON.stringify(mockUser));
        setToken(mockToken);
        setUser(mockUser);
        return { success: true };
      }
      return {
        success: false,
        message: error.response?.data?.message || 'Login failed. Please check your credentials.',
      };
    }
  };

  const logout = async () => {
    try {
      if (token && token !== 'mock-jwt-token-12345') {
        await api.post('/logout');
      }
    } catch (e) {
      console.error('Logout error', e);
    } finally {
      localStorage.removeItem('token');
      localStorage.removeItem('user');
      setToken(null);
      setUser(null);
    }
  };

  return (
    <AuthContext.Provider value={{ user, token, login, logout, loading, isAuthenticated: !!token }}>
      {children}
    </AuthContext.Provider>
  );
};

export const useAuth = () => useContext(AuthContext);

