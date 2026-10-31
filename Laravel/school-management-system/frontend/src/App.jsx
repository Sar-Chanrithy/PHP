import React from 'react';
import { BrowserRouter, Routes, Route, Navigate } from 'react-router-dom';
import { AuthProvider } from './context/AuthContext';
import ProtectedRoute from './components/ProtectedRoute';
import Layout from './components/Layout';
import Login from './pages/Login';
import Dashboard from './pages/Dashboard';
import StudentList from './pages/students/StudentList';
import TeacherList from './pages/teachers/TeacherList';
import ClassList from './pages/classes/ClassList';

function App() {
  return (
    <AuthProvider>
      <BrowserRouter>
        <Routes>
          {/* Public Route */}
          <Route path="/login" element={<Login />} />

          {/* Protected Routes wrapped inside Layout */}
          <Route element={<ProtectedRoute />}>
            <Route element={<Layout />}>
              <Route path="/" element={<Navigate to="/dashboard" replace />} />
              <Route path="/dashboard" element={<Dashboard />} />
              <Route path="/students" element={<StudentList />} />
              <Route path="/teachers" element={<TeacherList />} />
              <Route path="/classes" element={<ClassList />} />

              {/* Placeholder routes for remaining sidebar items */}
              <Route
                path="/attendance"
                element={
                  <div className="bg-white p-8 rounded-2xl border border-slate-200">
                    <h2 className="text-xl font-bold text-slate-800">Attendance Module</h2>
                    <p className="text-slate-500 mt-2">Manage daily student & staff attendance records here.</p>
                  </div>
                }
              />
              <Route
                path="/fees"
                element={
                  <div className="bg-white p-8 rounded-2xl border border-slate-200">
                    <h2 className="text-xl font-bold text-slate-800">Fee Collection Module</h2>
                    <p className="text-slate-500 mt-2">Invoices, payment logs, and tuition fees management.</p>
                  </div>
                }
              />
              <Route
                path="/exams"
                element={
                  <div className="bg-white p-8 rounded-2xl border border-slate-200">
                    <h2 className="text-xl font-bold text-slate-800">Examinations Module</h2>
                    <p className="text-slate-500 mt-2">Schedule exams, assign grades and report cards.</p>
                  </div>
                }
              />
              <Route
                path="/timetable"
                element={
                  <div className="bg-white p-8 rounded-2xl border border-slate-200">
                    <h2 className="text-xl font-bold text-slate-800">Timetable & Schedule</h2>
                    <p className="text-slate-500 mt-2">Class timetable and teacher schedules.</p>
                  </div>
                }
              />
              <Route
                path="/reports"
                element={
                  <div className="bg-white p-8 rounded-2xl border border-slate-200">
                    <h2 className="text-xl font-bold text-slate-800">Reports & Analytics</h2>
                    <p className="text-slate-500 mt-2">Generate school performance and financial reports.</p>
                  </div>
                }
              />
              <Route
                path="/settings"
                element={
                  <div className="bg-white p-8 rounded-2xl border border-slate-200">
                    <h2 className="text-xl font-bold text-slate-800">System Settings</h2>
                    <p className="text-slate-500 mt-2">Configure school profile, academic year, and roles.</p>
                  </div>
                }
              />
            </Route>
          </Route>

          {/* Catch-all */}
          <Route path="*" element={<Navigate to="/dashboard" replace />} />
        </Routes>
      </BrowserRouter>
    </AuthProvider>
  );
}

export default App;
