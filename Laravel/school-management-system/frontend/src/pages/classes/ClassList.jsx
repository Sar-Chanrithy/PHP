import React, { useState } from 'react';
import Table from '../../components/Table';
import Button from '../../components/Button';
import Modal from '../../components/Modal';
import Input from '../../components/Input';
import { Search, Pencil, Trash2, Plus, Users, BookOpen } from 'lucide-react';

const initialClasses = [
  { id: 1, name: 'Grade 9-A', teacher: 'Dr. Michael Chen', room: 'Room 101', capacity: 35, studentsCount: 32 },
  { id: 2, name: 'Grade 9-B', teacher: 'Sarah Jenkins', room: 'Room 102', capacity: 35, studentsCount: 30 },
  { id: 3, name: 'Grade 10-A', teacher: 'Khemara Seng', room: 'Room 201', capacity: 40, studentsCount: 38 },
  { id: 4, name: 'Grade 11-B', teacher: 'Emily Watson', room: 'Room 205', capacity: 40, studentsCount: 35 },
  { id: 5, name: 'Grade 12-A', teacher: 'Bunthoeun Pich', room: 'Room 302', capacity: 35, studentsCount: 29 },
];

const ClassList = () => {
  const [classes, setClasses] = useState(initialClasses);
  const [searchTerm, setSearchTerm] = useState('');
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [editingClass, setEditingClass] = useState(null);

  const [formData, setFormData] = useState({
    name: '',
    teacher: '',
    room: '',
    capacity: 35,
    studentsCount: 0,
  });

  const handleOpenAddModal = () => {
    setEditingClass(null);
    setFormData({
      name: '',
      teacher: '',
      room: '',
      capacity: 35,
      studentsCount: 0,
    });
    setIsModalOpen(true);
  };

  const handleOpenEditModal = (item) => {
    setEditingClass(item);
    setFormData(item);
    setIsModalOpen(true);
  };

  const handleDelete = (id) => {
    if (window.confirm('Are you sure you want to delete this class?')) {
      setClasses(classes.filter((c) => c.id !== id));
    }
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    if (editingClass) {
      setClasses(
        classes.map((c) => (c.id === editingClass.id ? { ...formData, id: c.id } : c))
      );
    } else {
      setClasses([...classes, { ...formData, id: Date.now() }]);
    }
    setIsModalOpen(false);
  };

  const filteredClasses = classes.filter(
    (c) =>
      c.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
      c.teacher.toLowerCase().includes(searchTerm.toLowerCase()) ||
      c.room.toLowerCase().includes(searchTerm.toLowerCase())
  );

  const columns = [
    {
      header: 'Class / Grade Name',
      accessor: 'name',
      render: (row) => (
        <div className="flex items-center gap-2.5">
          <div className="p-2 rounded-lg bg-blue-50 text-blue-600">
            <BookOpen className="w-4 h-4" />
          </div>
          <span className="font-semibold text-slate-800">{row.name}</span>
        </div>
      ),
    },
    { header: 'Class Teacher', accessor: 'teacher' },
    { header: 'Room No', accessor: 'room' },
    {
      header: 'Enrolled Students',
      accessor: 'studentsCount',
      render: (row) => (
        <div className="flex items-center gap-2">
          <span className="text-sm font-medium text-slate-700">
            {row.studentsCount} / {row.capacity}
          </span>
          <div className="w-20 bg-slate-100 rounded-full h-2 overflow-hidden">
            <div
              className="bg-blue-600 h-2 rounded-full"
              style={{ width: `${Math.min(100, (row.studentsCount / row.capacity) * 100)}%` }}
            />
          </div>
        </div>
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
          <h1 className="text-2xl font-bold text-slate-800">Classes Management</h1>
          <p className="text-sm text-slate-500">Manage classrooms, sections, and assigned teachers</p>
        </div>
        <Button onClick={handleOpenAddModal} icon={Plus}>
          Add New Class
        </Button>
      </div>

      <div className="flex items-center justify-between bg-white p-4 rounded-xl border border-slate-200/80 shadow-xs gap-4">
        <div className="w-full max-w-sm">
          <Input
            placeholder="Search class by name, teacher, room..."
            value={searchTerm}
            onChange={(e) => setSearchTerm(e.target.value)}
            icon={Search}
          />
        </div>
        <span className="text-xs text-slate-500">
          Showing <b>{filteredClasses.length}</b> classes
        </span>
      </div>

      <Table columns={columns} data={filteredClasses} />

      <Modal
        isOpen={isModalOpen}
        onClose={() => setIsModalOpen(false)}
        title={editingClass ? 'Edit Class Details' : 'Add New Class'}
      >
        <form onSubmit={handleSubmit} className="space-y-4">
          <Input
            label="Class / Grade Name"
            value={formData.name}
            onChange={(e) => setFormData({ ...formData, name: e.target.value })}
            placeholder="e.g. Grade 10-A"
            required
          />

          <Input
            label="Class Teacher"
            value={formData.teacher}
            onChange={(e) => setFormData({ ...formData, teacher: e.target.value })}
            placeholder="e.g. Dr. Michael Chen"
            required
          />

          <div className="grid grid-cols-2 gap-4">
            <Input
              label="Room Number"
              value={formData.room}
              onChange={(e) => setFormData({ ...formData, room: e.target.value })}
              placeholder="e.g. Room 201"
              required
            />

            <Input
              label="Capacity"
              type="number"
              value={formData.capacity}
              onChange={(e) => setFormData({ ...formData, capacity: Number(e.target.value) })}
              required
            />
          </div>

          <div className="flex justify-end gap-3 pt-4 border-t border-slate-100">
            <Button variant="secondary" onClick={() => setIsModalOpen(false)}>
              Cancel
            </Button>
            <Button type="submit">
              {editingClass ? 'Save Changes' : 'Create Class'}
            </Button>
          </div>
        </form>
      </Modal>
    </div>
  );
};

export default ClassList;

