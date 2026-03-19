import LmsLayout from '@/Layouts/LmsLayout';
import { Head } from '@inertiajs/react';
import { useState } from 'react';

export default function MaterialsIndex({ auth, materials }) {
    const [search, setSearch] = useState('');

    const allMaterials = materials || [
        { id: 1, name: 'Week 1 – HTML & CSS Notes', course: 'Full Stack Web Dev', type: 'pdf', size: '2.4 MB', date: '2026-03-01' },
        { id: 2, name: 'Week 2 – JavaScript Basics', course: 'Full Stack Web Dev', type: 'pdf', size: '3.1 MB', date: '2026-03-08' },
        { id: 3, name: 'Pandas & NumPy Cheatsheet', course: 'Data Science & ML', type: 'pdf', size: '1.8 MB', date: '2026-03-05' },
        { id: 4, name: 'UX Research Methods', course: 'UI/UX Design', type: 'pdf', size: '4.2 MB', date: '2026-03-10' },
        { id: 5, name: 'React Hooks Reference Guide', course: 'Full Stack Web Dev', type: 'pdf', size: '1.5 MB', date: '2026-03-15' },
        { id: 6, name: 'ML Assignment – Week 3', course: 'Data Science & ML', type: 'doc', size: '880 KB', date: '2026-03-18' },
    ];

    const filtered = allMaterials.filter(m =>
        m.name.toLowerCase().includes(search.toLowerCase()) || m.course.toLowerCase().includes(search.toLowerCase())
    );

    const typeIcon  = { pdf: 'bi-file-earmark-pdf-fill', doc: 'bi-file-earmark-word-fill', zip: 'bi-file-earmark-zip-fill' };
    const typeColor = { pdf: '#ef4444', doc: '#3b82f6', zip: '#f59e0b' };

    return (
        <LmsLayout title="Study Materials">
            <Head title="Study Materials" />

            <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', marginBottom: '20px' }}>
                <div>
                    <h2 style={{ color: '#1f2937', fontSize: '20px', fontWeight: 700, margin: 0 }}>Study Materials</h2>
                    <p style={{ color: '#6b7280', fontSize: '13px', margin: '4px 0 0 0' }}>Download course materials and resources</p>
                </div>
                {/* Search */}
                <div style={{ position: 'relative' }}>
                    <i className="bi bi-search" style={{ position: 'absolute', left: '10px', top: '50%', transform: 'translateY(-50%)', color: '#9ca3af', fontSize: '13px' }}></i>
                    <input
                        type="text"
                        placeholder="Search materials..."
                        value={search}
                        onChange={e => setSearch(e.target.value)}
                        style={{ padding: '8px 10px 8px 32px', border: '1px solid #e5e7eb', borderRadius: '6px', fontSize: '13px', color: '#1f2937', outline: 'none', width: '220px' }}
                        onFocus={e => e.target.style.borderColor = '#3b82f6'}
                        onBlur={e => e.target.style.borderColor = '#e5e7eb'}
                    />
                </div>
            </div>

            {/* Materials Grid */}
            <div className="row g-3">
                {filtered.map(mat => (
                    <div key={mat.id} className="col-12 col-md-6 col-lg-4">
                        <div style={{
                            background: '#fff', borderRadius: '8px', boxShadow: '0 1px 3px rgba(0,0,0,0.08)',
                            padding: '16px', transition: 'transform 0.15s, box-shadow 0.15s',
                        }}
                            onMouseEnter={e => { e.currentTarget.style.transform = 'translateY(-3px)'; e.currentTarget.style.boxShadow = '0 6px 18px rgba(0,0,0,0.1)'; }}
                            onMouseLeave={e => { e.currentTarget.style.transform = ''; e.currentTarget.style.boxShadow = '0 1px 3px rgba(0,0,0,0.08)'; }}
                        >
                            <div style={{ display: 'flex', gap: '12px', marginBottom: '12px' }}>
                                <div style={{ width: '40px', height: '40px', borderRadius: '8px', background: `${typeColor[mat.type] || '#3b82f6'}18`, display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0 }}>
                                    <i className={`bi ${typeIcon[mat.type] || 'bi-file-earmark'}`} style={{ color: typeColor[mat.type] || '#3b82f6', fontSize: '20px' }}></i>
                                </div>
                                <div>
                                    <div style={{ color: '#1f2937', fontSize: '14px', fontWeight: 600, lineHeight: 1.3 }}>{mat.name}</div>
                                    <div style={{ color: '#6b7280', fontSize: '12px' }}>{mat.course}</div>
                                </div>
                            </div>
                            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', paddingTop: '10px', borderTop: '1px solid #f3f4f6' }}>
                                <span style={{ color: '#9ca3af', fontSize: '11px' }}>
                                    <i className="bi bi-hdd me-1"></i>{mat.size} · {mat.date}
                                </span>
                                <a href="#" style={{ padding: '5px 12px', background: '#eff6ff', border: '1px solid #bfdbfe', color: '#2563eb', borderRadius: '5px', textDecoration: 'none', fontSize: '12px', fontWeight: 600 }}>
                                    <i className="bi bi-download me-1"></i> Download
                                </a>
                            </div>
                        </div>
                    </div>
                ))}
                {filtered.length === 0 && (
                    <div className="col-12" style={{ textAlign: 'center', padding: '60px', color: '#9ca3af' }}>
                        <i className="bi bi-folder-x" style={{ fontSize: '40px', display: 'block', marginBottom: '10px' }}></i>
                        No materials found.
                    </div>
                )}
            </div>
        </LmsLayout>
    );
}
