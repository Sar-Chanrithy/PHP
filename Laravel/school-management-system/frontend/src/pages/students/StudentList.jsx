import React, { useState } from 'react';
import Table from '../../components/Table';
import Button from '../../components/Button';
import Modal from '../../components/Modal';
import Input from '../../components/Input';
import { Plus, Search, Pencil, Trash2, UserPlus } from 'lucide-react';

const initialStudents = [
  { id: 1, name: 'Sokha Chan', gender: 'Male', rollNo: 'STU-1001', grade: 'Grade 10-A', phone: '012 345 678', status: 'Active' },
  { id: 2, name: 'Bopha Meas', gender: 'Female', rollNo: 'STU-1002', grade: 'Grade 10-A', phone: '089 987 654', status: 'Active' },
  { id: 3, name: 'Dara Chea', gender: 'Male', rollNo: 'STU-1003', grade: 'Grade 11-B', phone: '098 765 432', status: 'Active' },
  { id: 4, name: 'Sreynet Lim', gender: 'Female', rollNo: 'STU-1004', grade: 'Grade 9-C', phone: '015 223 344', status: 'Inactive' },
  { id: 5, name: 'Vannak Heng', gender: 'Male', rollNo: 'STU-1005', grade: 'Grade 12-A', phone: '077 556 677', status: 'Active' },
];

const StudentList = () => {
  const [students, setStudents] = useState(initialStudents);
  const [searchTerm, setSearchTerm] = useState('');
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [editingStudent, setEditingStudent] = useState(null);

  // Form State
  const [formData, setFormData] = useState({
    name: '',
    gender: 'Male',
    rollNo: '',
    grade: 'Grade 10-A',
    phone: '',
    status: 'Active',
  });

  const handleOpenAddModal = () => {
    setEditingStudent(null);
    setFormData({
      name: '',
      gender: 'Male',
      rollNo: `STU-${1000 + students.length + 1}`,
      grade: 'Grade 10-A',
      phone: '',
      status: 'Active',
    });
    setIsModalOpen(true);
  };

  const handleOpenEditModal = (student) => {
    setEditingStudent(student);
    setFormData(student);
    setIsModalOpen(true);
  };

  const handleDelete = (id) => {
    if (window.confirm('Are you sure you want to delete this student record?')) {
      setStudents(students.filter((s) => s.id !== id));
    }
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    if (editingStudent) {
      setStudents(
        students.map((s) => (s.id === editingStudent.id ? { ...formData, id: s.id } : s))
      );
    } else {
      setStudents([...students, { ...formData, id: Date.now() }]);
    }
    setIsModalOpen(false);
  };

  const filteredStudents = students.filter(
    (s) =>
      s.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
      s.rollNo.toLowerCase().includes(searchTerm.toLowerCase()) ||
      s.grade.toLowerCase().includes(searchTerm.toLowerCase())
  );

  const columns = [
    {
      header: 'Roll No',
      accessor: 'rollNo',
      render: (row) => <span className="font-semibold text-blue-600">{row.rollNo}</span>,
    },
    {
      header: 'Name',
      accessor: 'name',
      render: (row) => (
        <div className="flex items-center gap-3">
          <div className="w-8 h-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-xs">
            {row.name.charAt(0)}
          </div>
          <span className="font-medium text-slate-800">{row.name}</span>
        </div>
      ),
    },
    { header: 'Gender', accessor: 'gender' },
    { header: 'Class / Grade', accessor: 'grade' },
    { header: 'Phone', accessor: 'phone' },
    {
      header: 'Status',
      accessor: 'status',
      render: (row) => (
        <span
          className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${
            row.status === 'Active'
              ? 'bg-emerald-50 text-emerald-700 border border-emerald-200'
              : 'bg-slate-100 text-slate-600 border border-slate-200'
          }`}
        >
          {row.status}
        </span>
      ),
    },
    {
      header: 'Actions',
      render: (row) => (
        <div className="flex items-center gap-2">
          <button
            onClick={() => handleOpenEditModal(row)}
            className="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
            title="Edit"
          >
            <Pencil className="w-4 h-4" />
          </button>
          <button
            onClick={() => handleDelete(row.id)}
            className="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
            title="Delete"
          >
            <Trash2 className="w-4 h-4" />
          </button>
        </div>
      ),
    },
  ];

  return (
    <div className="space-y-6">
      <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <h1 className="text-2xl font-bold text-slate-800">Students Management</h1>
          <p className="text-sm text-slate-500">Manage all registered school students</p>
        </div>
        <Button onClick={handleOpenAddModal} icon={UserPlus}>
          Add New Student
        </Button>
      </div>

      {/* Filter and Search Bar */}
      <div className="flex items-center justify-between bg-white p-4 rounded-xl border border-slate-200/80 shadow-xs gap-4">
        <div className="w-full max-w-sm">
          <Input
            placeholder="Search by name, roll no, class..."
            value={searchTerm}
            onChange={(e) => setSearchTerm(e.target.value)}
            icon={Search}
          />
        </div>
        <span className="text-xs text-slate-500">
          Showing <b>{filteredStudents.length}</b> students
        </span>
      </div>

      {/* Table Component */}
      <Table columns={columns} data={filteredStudents} />

      {/* Modal for Add / Edit */}
      <Modal
        isOpen={isModalOpen}
        onClose={() => setIsModalOpen(false)}
        title={editingStudent ? 'Edit Student Details' : 'Add New Student'}
      >
        <form onSubmit={handleSubmit} className="space-y-4">
          <Input
            label="Full Name"
            value={formData.name}
            onChange={(e) => setFormData({ ...formData, name: e.target.value })}
            placeholder="e.g. Sokha Chan"
            required
          />

          <div className="grid grid-cols-2 gap-4">
            <div>
              <label className="block text-sm font-medium text-slate-700 mb-1.5">Gender</label>
              <select
                value={formData.gender}
                onChange={(e) => setFormData({ ...formData, gender: e.target.value })}
                className="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500"
              >
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
            </div>

            <Input
              label="Roll Number"
              value={formData.rollNo}
              onChange={(e) => setFormData({ ...formData, rollNo: e.target.value })}
              placeholder="STU-1001"
              required
            />
          </div>

          <div className="grid grid-cols-2 gap-4">
            <div>
              <label className="block text-sm font-medium text-slate-700 mb-1.5">Class / Grade</label>
              <select
                value={formData.grade}
                onChange={(e) => setFormData({ ...formData, grade: e.target.value })}
                className="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500"
              >
                <option value="Grade 9-A">Grade 9-A</option>
                <option value="Grade 9-B">Grade 9-B</option>
                <option value="Grade 10-A">Grade 10-A</option>
                <option value="Grade 11-B">Grade 11-B</option>
                <option value="Grade 12-A">Grade 12-A</option>
              </select>
            </div>

            <Input
              label="Phone Number"
              value={formData.phone}
              onChange={(e) => setFormData({ ...formData, phone: e.target.value })}
              placeholder="012 345 678"
            />
          </div>

          <div>
            <label className="block text-sm font-medium text-slate-700 mb-1.5">Status</label>
            <select
              value={formData.status}
              onChange={(e) => setFormData({ ...formData, status: e.target.value })}
              className="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500"
            >
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
          </div>

          <div className="flex justify-end gap-3 pt-4 border-t border-slate-100">
            <Button variant="secondary" onClick={() => setIsModalOpen(false)}>
              Cancel
            </Button>
            <Button type="submit">
              {editingStudent ? 'Save Changes' : 'Create Student'}
            </Button>
          </div>
        </form>
      </Modal>
    </div>
  );
};

export default StudentList;

