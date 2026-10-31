import React, { useState } from 'react';
import Table from '../../components/Table';
import Button from '../../components/Button';
import Modal from '../../components/Modal';
import Input from '../../components/Input';
import { Search, Pencil, Trash2, UserPlus, Mail } from 'lucide-react';

const initialTeachers = [
  { id: 1, name: 'Dr. Michael Chen', subject: 'Mathematics', email: 'm.chen@school.com', phone: '012 888 999', qualification: 'Ph.D. in Mathematics' },
  { id: 2, name: 'Sarah Jenkins', subject: 'Physics', email: 's.jenkins@school.com', phone: '089 777 666', qualification: 'M.Sc. Physics' },
  { id: 3, name: 'Khemara Seng', subject: 'Khmer Literature', email: 'k.seng@school.com', phone: '098 555 444', qualification: 'B.Ed. Khmer' },
  { id: 4, name: 'Emily Watson', subject: 'English', email: 'e.watson@school.com', phone: '015 111 222', qualification: 'M.A. Linguistics' },
  { id: 5, name: 'Bunthoeun Pich', subject: 'Chemistry', email: 'b.pich@school.com', phone: '077 333 222', qualification: 'B.Sc. Chemistry' },
];

const TeacherList = () => {
  const [teachers, setTeachers] = useState(initialTeachers);
  const [searchTerm, setSearchTerm] = useState('');
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [editingTeacher, setEditingTeacher] = useState(null);

  const [formData, setFormData] = useState({
    name: '',
    subject: '',
    email: '',
    phone: '',
    qualification: '',
  });

  const handleOpenAddModal = () => {
    setEditingTeacher(null);
    setFormData({
      name: '',
      subject: '',
      email: '',
      phone: '',
      qualification: '',
    });
    setIsModalOpen(true);
  };

  const handleOpenEditModal = (teacher) => {
    setEditingTeacher(teacher);
    setFormData(teacher);
    setIsModalOpen(true);
  };

  const handleDelete = (id) => {
    if (window.confirm('Are you sure you want to delete this teacher?')) {
      setTeachers(teachers.filter((t) => t.id !== id));
    }
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    if (editingTeacher) {
      setTeachers(
        teachers.map((t) => (t.id === editingTeacher.id ? { ...formData, id: t.id } : t))
      );
    } else {
      setTeachers([...teachers, { ...formData, id: Date.now() }]);
    }
    setIsModalOpen(false);
  };

  const filteredTeachers = teachers.filter(
    (t) =>
      t.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
      t.subject.toLowerCase().includes(searchTerm.toLowerCase()) ||
      t.email.toLowerCase().includes(searchTerm.toLowerCase())
  );

  const columns = [
    {
      header: 'Name',
      accessor: 'name',
      render: (row) => (
        <div className="flex items-center gap-3">
          <div className="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs">
            {row.name.charAt(0)}
          </div>
          <div>
            <span className="font-medium text-slate-800 block">{row.name}</span>
            <span className="text-xs text-slate-400">{row.email}</span>
          </div>
        </div>
      ),
    },
    {
      header: 'Subject',
      accessor: 'subject',
      render: (row) => (
        <span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
          {row.subject}
        </span>
      ),
    },
    { header: 'Qualification', accessor: 'qualification' },
    { header: 'Phone', accessor: 'phone' },
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
          <h1 className="text-2xl font-bold text-slate-800">Teachers Management</h1>
          <p className="text-sm text-slate-500">Manage academic instructors and teachers</p>
        </div>
        <Button onClick={handleOpenAddModal} icon={UserPlus}>
          Add New Teacher
        </Button>
      </div>

      <div className="flex items-center justify-between bg-white p-4 rounded-xl border border-slate-200/80 shadow-xs gap-4">
        <div className="w-full max-w-sm">
          <Input
            placeholder="Search teacher by name or subject..."
            value={searchTerm}
            onChange={(e) => setSearchTerm(e.target.value)}
            icon={Search}
          />
        </div>
        <span className="text-xs text-slate-500">
          Showing <b>{filteredTeachers.length}</b> teachers
        </span>
      </div>

      <Table columns={columns} data={filteredTeachers} />

      <Modal
        isOpen={isModalOpen}
        onClose={() => setIsModalOpen(false)}
        title={editingTeacher ? 'Edit Teacher Details' : 'Add New Teacher'}
      >
        <form onSubmit={handleSubmit} className="space-y-4">
          <Input
            label="Full Name"
            value={formData.name}
            onChange={(e) => setFormData({ ...formData, name: e.target.value })}
            placeholder="e.g. Dr. Michael Chen"
            required
          />

          <Input
            label="Subject Specialization"
            value={formData.subject}
            onChange={(e) => setFormData({ ...formData, subject: e.target.value })}
            placeholder="e.g. Mathematics"
            required
          />

          <div className="grid grid-cols-2 gap-4">
            <Input
              label="Email"
              type="email"
              value={formData.email}
              onChange={(e) => setFormData({ ...formData, email: e.target.value })}
              placeholder="teacher@school.com"
              icon={Mail}
              required
            />

            <Input
              label="Phone"
              value={formData.phone}
              onChange={(e) => setFormData({ ...formData, phone: e.target.value })}
              placeholder="012 345 678"
            />
          </div>

          <Input
            label="Qualification / Degree"
            value={formData.qualification}
            onChange={(e) => setFormData({ ...formData, qualification: e.target.value })}
            placeholder="e.g. Master of Science"
          />

          <div className="flex justify-end gap-3 pt-4 border-t border-slate-100">
            <Button variant="secondary" onClick={() => setIsModalOpen(false)}>
              Cancel
            </Button>
            <Button type="submit">
              {editingTeacher ? 'Save Changes' : 'Create Teacher'}
            </Button>
          </div>
        </form>
      </Modal>
    </div>
  );
};

export default TeacherList;

