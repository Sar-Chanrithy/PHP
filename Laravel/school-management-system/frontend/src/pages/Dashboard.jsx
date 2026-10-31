import React from 'react';
import {
  Users,
  UserCheck,
  CalendarCheck,
  CreditCard,
  Megaphone,
  Calendar,
  ChevronRight,
  TrendingUp,
} from 'lucide-react';
import { Link } from 'react-router-dom';

const Dashboard = () => {
  return (
    <div className="space-y-6">
      {/* Header title */}
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-2xl font-bold text-slate-800">Dashboard</h1>
          <p className="text-sm text-slate-500">Welcome to Greenfield High School administration overview</p>
        </div>
      </div>

      {/* Top 4 Stat Cards - matching the uploaded design */}
      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        {/* Card 1: Students */}
        <div className="bg-[#eff6ff] border border-blue-100 rounded-2xl p-5 shadow-xs hover:shadow-md transition-shadow">
          <div className="flex items-center justify-between">
            <div className="w-12 h-12 rounded-xl bg-blue-500 text-white flex items-center justify-center shadow-sm">
              <Users className="w-6 h-6" />
            </div>
            <div className="text-right">
              <span className="text-xs font-semibold text-blue-600 uppercase tracking-wider">Students</span>
              <h3 className="text-2xl font-bold text-slate-800">1,250</h3>
            </div>
          </div>
          <div className="mt-4 pt-3 border-t border-blue-200/60 flex justify-between items-center text-xs">
            <Link to="/students" className="text-blue-600 font-medium hover:underline inline-flex items-center">
              View all <ChevronRight className="w-3.5 h-3.5 ml-0.5" />
            </Link>
          </div>
        </div>

        {/* Card 2: Teachers */}
        <div className="bg-[#f0fdf4] border border-emerald-100 rounded-2xl p-5 shadow-xs hover:shadow-md transition-shadow">
          <div className="flex items-center justify-between">
            <div className="w-12 h-12 rounded-xl bg-emerald-500 text-white flex items-center justify-center shadow-sm">
              <UserCheck className="w-6 h-6" />
            </div>
            <div className="text-right">
              <span className="text-xs font-semibold text-emerald-600 uppercase tracking-wider">Teachers</span>
              <h3 className="text-2xl font-bold text-slate-800">85</h3>
            </div>
          </div>
          <div className="mt-4 pt-3 border-t border-emerald-200/60 flex justify-between items-center text-xs">
            <Link to="/teachers" className="text-emerald-600 font-medium hover:underline inline-flex items-center">
              View all <ChevronRight className="w-3.5 h-3.5 ml-0.5" />
            </Link>
          </div>
        </div>

        {/* Card 3: Attendance */}
        <div className="bg-[#faf5ff] border border-purple-100 rounded-2xl p-5 shadow-xs hover:shadow-md transition-shadow">
          <div className="flex items-center justify-between">
            <div className="w-12 h-12 rounded-xl bg-purple-500 text-white flex items-center justify-center shadow-sm">
              <CalendarCheck className="w-6 h-6" />
            </div>
            <div className="text-right">
              <span className="text-xs font-semibold text-purple-600 uppercase tracking-wider">Attendance</span>
              <h3 className="text-2xl font-bold text-slate-800">92%</h3>
            </div>
          </div>
          <div className="mt-4 pt-3 border-t border-purple-200/60 flex justify-between items-center text-xs">
            <span className="text-purple-600 font-medium cursor-pointer hover:underline inline-flex items-center">
              View all <ChevronRight className="w-3.5 h-3.5 ml-0.5" />
            </span>
          </div>
        </div>

        {/* Card 4: Fees Collection */}
        <div className="bg-[#fffbeb] border border-amber-100 rounded-2xl p-5 shadow-xs hover:shadow-md transition-shadow">
          <div className="flex items-center justify-between">
            <div className="w-12 h-12 rounded-xl bg-amber-500 text-white flex items-center justify-center shadow-sm">
              <CreditCard className="w-6 h-6" />
            </div>
            <div className="text-right">
              <span className="text-xs font-semibold text-amber-600 uppercase tracking-wider">Fees Collection</span>
              <h3 className="text-2xl font-bold text-slate-800">$ 8,75,000</h3>
            </div>
          </div>
          <div className="mt-4 pt-3 border-t border-amber-200/60 flex justify-between items-center text-xs">
            <span className="text-amber-600 font-medium cursor-pointer hover:underline inline-flex items-center">
              View all <ChevronRight className="w-3.5 h-3.5 ml-0.5" />
            </span>
          </div>
        </div>
      </div>

      {/* Middle Section: Attendance Overview + Recent Announcements */}
      <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {/* Attendance Chart Overview */}
        <div className="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs">
          <div className="flex items-center justify-between mb-4">
            <h3 className="text-base font-semibold text-slate-800">Attendance Overview</h3>
            <span className="text-xs text-slate-400 font-medium">This Week</span>
          </div>

          <div className="relative pt-4">
            {/* SVG line chart mimic */}
            <svg viewBox="0 0 500 200" className="w-full h-44 overflow-visible">
              <defs>
                <linearGradient id="chartGradient" x1="0" y1="0" x2="0" y2="1">
                  <stop offset="0%" stopColor="#3b82f6" stopOpacity="0.3" />
                  <stop offset="100%" stopColor="#3b82f6" stopOpacity="0.0" />
                </linearGradient>
              </defs>

              {/* Grid lines */}
              <line x1="40" y1="20" x2="480" y2="20" stroke="#f1f5f9" strokeDasharray="4 4" />
              <line x1="40" y1="75" x2="480" y2="75" stroke="#f1f5f9" strokeDasharray="4 4" />
              <line x1="40" y1="130" x2="480" y2="130" stroke="#f1f5f9" strokeDasharray="4 4" />
              <line x1="40" y1="180" x2="480" y2="180" stroke="#e2e8f0" />

              {/* Y Axis text */}
              <text x="5" y="25" fill="#94a3b8" fontSize="11">100%</text>
              <text x="12" y="80" fill="#94a3b8" fontSize="11">50%</text>
              <text x="18" y="135" fill="#94a3b8" fontSize="11">0%</text>

              {/* Area Under Curve */}
              <path
                d="M 50 120 L 130 90 L 210 60 L 290 100 L 370 70 L 450 40 L 450 180 L 50 180 Z"
                fill="url(#chartGradient)"
              />

              {/* Main Line */}
              <path
                d="M 50 120 L 130 90 L 210 60 L 290 100 L 370 70 L 450 40"
                fill="none"
                stroke="#2563eb"
                strokeWidth="3"
                strokeLinecap="round"
                strokeLinejoin="round"
              />

              {/* Dots */}
              {[
                { cx: 50, cy: 120, label: 'Mon' },
                { cx: 130, cy: 90, label: 'Tue' },
                { cx: 210, cy: 60, label: 'Wed' },
                { cx: 290, cy: 100, label: 'Thu' },
                { cx: 370, cy: 70, label: 'Fri' },
                { cx: 450, cy: 40, label: 'Sat' },
              ].map((pt, i) => (
                <g key={i}>
                  <circle cx={pt.cx} cy={pt.cy} r="4.5" fill="#2563eb" stroke="#fff" strokeWidth="2" />
                  <text x={pt.cx} y="196" textAnchor="middle" fill="#64748b" fontSize="11">
                    {pt.label}
                  </text>
                </g>
              ))}
            </svg>
          </div>
        </div>

        {/* Recent Announcements */}
        <div className="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between">
          <div className="flex items-center justify-between mb-4">
            <div className="flex items-center gap-2">
              <Megaphone className="w-5 h-5 text-blue-600" />
              <h3 className="text-base font-semibold text-slate-800">Recent Announcements</h3>
            </div>
            <span className="text-xs text-blue-600 font-medium cursor-pointer hover:underline">View all</span>
          </div>

          <div className="space-y-4">
            {[
              { title: 'Annual Sports Day on 25th May', date: '20 May, 2026' },
              { title: 'Parent-Teacher Meeting on 30th May', date: '18 May, 2026' },
              { title: 'Summer Vacation from 1st June', date: '15 May, 2026' },
            ].map((item, idx) => (
              <div key={idx} className="flex items-center justify-between py-2 border-b border-slate-100 last:border-0">
                <span className="text-sm font-medium text-slate-700 hover:text-blue-600 cursor-pointer">
                  {item.title}
                </span>
                <span className="text-xs text-slate-400 whitespace-nowrap ml-4">{item.date}</span>
              </div>
            ))}
          </div>
          <div className="pt-2"></div>
        </div>
      </div>

      {/* Bottom Section: Fee Collection Donut + Upcoming Exams */}
      <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {/* Fee Collection Donut Breakdown */}
        <div className="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs">
          <h3 className="text-base font-semibold text-slate-800 mb-4">Fee Collection</h3>

          <div className="flex flex-col sm:flex-row items-center justify-around gap-6 pt-2">
            {/* SVG Donut */}
            <div className="relative w-44 h-44 flex items-center justify-center">
              <svg viewBox="0 0 36 36" className="w-full h-full transform -rotate-90">
                {/* Background circle */}
                <circle cx="18" cy="18" r="14" fill="transparent" stroke="#f1f5f9" strokeWidth="4.5" />
                {/* Collected slice (green: 65%) */}
                <circle
                  cx="18"
                  cy="18"
                  r="14"
                  fill="transparent"
                  stroke="#22c55e"
                  strokeWidth="4.5"
                  strokeDasharray="60 100"
                  strokeDashoffset="0"
                />
                {/* Pending slice (orange: 25%) */}
                <circle
                  cx="18"
                  cy="18"
                  r="14"
                  fill="transparent"
                  stroke="#f97316"
                  strokeWidth="4.5"
                  strokeDasharray="25 100"
                  strokeDashoffset="-60"
                />
                {/* Overdue slice (red: 10%) */}
                <circle
                  cx="18"
                  cy="18"
                  r="14"
                  fill="transparent"
                  stroke="#ef4444"
                  strokeWidth="4.5"
                  strokeDasharray="10 100"
                  strokeDashoffset="-85"
                />
              </svg>
              <div className="absolute flex flex-col items-center">
                <span className="text-xs text-slate-400">Total</span>
                <span className="text-base font-bold text-slate-800">$ 8,75,000</span>
              </div>
            </div>

            {/* Legend list */}
            <div className="space-y-3">
              <div className="flex items-center gap-3">
                <span className="w-3 h-3 rounded-full bg-emerald-500"></span>
                <div>
                  <p className="text-xs text-slate-400">Collected</p>
                  <p className="text-sm font-semibold text-slate-800">$ 6,25,000</p>
                </div>
              </div>
              <div className="flex items-center gap-3">
                <span className="w-3 h-3 rounded-full bg-amber-500"></span>
                <div>
                  <p className="text-xs text-slate-400">Pending</p>
                  <p className="text-sm font-semibold text-slate-800">$ 2,00,000</p>
                </div>
              </div>
              <div className="flex items-center gap-3">
                <span className="w-3 h-3 rounded-full bg-red-500"></span>
                <div>
                  <p className="text-xs text-slate-400">Overdue</p>
                  <p className="text-sm font-semibold text-slate-800">$ 50,000</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        {/* Upcoming Exams */}
        <div className="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs">
          <div className="flex items-center justify-between mb-4">
            <h3 className="text-base font-semibold text-slate-800">Upcoming Exams</h3>
            <span className="text-xs text-blue-600 font-medium cursor-pointer hover:underline">View all</span>
          </div>

          <div className="space-y-3">
            {[
              { name: 'Unit Test - 1', date: '10 Jun, 2026' },
              { name: 'Half Yearly Exam', date: '15 Jul, 2026' },
              { name: 'Final Exam', date: '20 Mar, 2027' },
            ].map((exam, i) => (
              <div
                key={i}
                className="flex items-center justify-between p-3.5 rounded-xl border border-slate-100 hover:border-blue-200 bg-slate-50/50 hover:bg-blue-50/30 transition-colors"
              >
                <div className="flex items-center gap-3">
                  <div className="w-9 h-9 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                    <Calendar className="w-5 h-5" />
                  </div>
                  <div>
                    <h4 className="text-sm font-semibold text-slate-800">{exam.name}</h4>
                    <p className="text-xs text-slate-400">{exam.date}</p>
                  </div>
                </div>
                <button className="text-slate-400 hover:text-blue-600">
                  <Calendar className="w-4 h-4" />
                </button>
              </div>
            ))}
          </div>
        </div>
      </div>
    </div>
  );
};

export default Dashboard;

