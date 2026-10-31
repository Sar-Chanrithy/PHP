import React from 'react';
import { NavLink } from 'react-router-dom';
import {
  GraduationCap,
  LayoutDashboard,
  Users,
  UserCheck,
  CalendarCheck,
  CreditCard,
  FileText,
  Calendar,
  BookOpen,
  BarChart3,
  Settings,
} from 'lucide-react';

const navItems = [
  { name: 'Dashboard', path: '/dashboard', icon: LayoutDashboard },
  { name: 'Students', path: '/students', icon: Users },
  { name: 'Teachers', path: '/teachers', icon: UserCheck },
  { name: 'Classes', path: '/classes', icon: BookOpen },
  { name: 'Attendance', path: '/attendance', icon: CalendarCheck },
  { name: 'Fees', path: '/fees', icon: CreditCard },
  { name: 'Exams', path: '/exams', icon: FileText },
  { name: 'Timetable', path: '/timetable', icon: Calendar },
  { name: 'Reports', path: '/reports', icon: BarChart3 },
  { name: 'Settings', path: '/settings', icon: Settings },
];

const Sidebar = () => {
  return (
    <aside className="w-64 bg-[#0a2558] text-white flex flex-col shrink-0 min-h-screen select-none transition-all duration-300">
      {/* Brand / Logo matching the uploaded design */}
      <div className="flex items-center gap-3 px-6 py-6 border-b border-blue-900/40">
        <div className="w-10 h-10 rounded-xl bg-blue-600/30 border border-blue-400/30 flex items-center justify-center text-blue-200">
          <GraduationCap className="w-6 h-6" />
        </div>
        <div className="leading-tight">
          <h1 className="text-base font-bold tracking-wide text-white">Greenfield</h1>
          <p className="text-xs text-blue-200/70 font-light">High School</p>
        </div>
      </div>

      {/* Nav Menu */}
      <nav className="flex-1 px-3 py-4 space-y-1.5 overflow-y-auto">
        {navItems.map((item) => {
          const Icon = item.icon;
          return (
            <NavLink
              key={item.name}
              to={item.path}
              className={({ isActive }) =>
                `flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-sm transition-all duration-150 ${
                  isActive
                    ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30 font-semibold'
                    : 'text-blue-100/75 hover:bg-white/10 hover:text-white'
                }`
              }
            >
              <Icon className="w-5 h-5 shrink-0" />
              <span>{item.name}</span>
            </NavLink>
          );
        })}
      </nav>

      {/* Footer Info */}
      <div className="p-4 border-t border-blue-900/40 text-xs text-blue-300/60 text-center">
        School System v1.0
      </div>
    </aside>
  );
};

export default Sidebar;

