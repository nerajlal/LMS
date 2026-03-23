import { useState } from 'react';
import LmsLayout from '@/Layouts/LmsLayout';
import { Head, Link } from '@inertiajs/react';

const CourseHorizontalCard = ({ course, status, progress = 45 }) => (
    <div style={{ 
        background: '#fff', 
        borderRadius: '12px', 
        border: '1px solid #f1f5f9', 
        padding: '16px', 
        display: 'flex', 
        gap: '20px', 
        marginBottom: '16px',
        alignItems: 'center'
    }}>
        <div style={{ width: '120px', height: '80px', borderRadius: '8px', overflow: 'hidden', flexShrink: 0, position: 'relative', background: '#f1f5f9' }}>
            <div style={{ position: 'absolute', inset: 0, display: 'flex', alignItems: 'center', justifyContent: 'center', background: 'rgba(0,0,0,0.1)' }}>
                <i className="bi bi-play-circle-fill" style={{ color: '#fff', fontSize: '32px' }}></i>
            </div>
            <img src={`https://via.placeholder.com/120x80?text=${course}`} alt="" style={{ width: '100%', height: '100%', objectFit: 'cover' }} />
        </div>
        <div style={{ flex: 1, minWidth: 0 }}>
            <div style={{ color: '#1e293b', fontWeight: 700, fontSize: '16px', marginBottom: '4px', whiteSpace: 'nowrap', overflow: 'hidden', textOverflow: 'ellipsis' }}>{course}</div>
            <div style={{ color: '#64748b', fontSize: '13px', marginBottom: '12px' }}>Instructor Name</div>
            <div style={{ display: 'flex', alignItems: 'center', gap: '12px' }}>
                <div style={{ fontSize: '12px', color: '#64748b', fontWeight: 600 }}>{Math.round(progress/10)}/10 Complete</div>
                <div style={{ flex: 1, height: '4px', background: '#f1f5f9', borderRadius: '10px', overflow: 'hidden' }}>
                    <div style={{ width: `${progress}%`, height: '100%', background: '#e3000f' }}></div>
                </div>
            </div>
        </div>
        <div style={{ textAlign: 'right' }}>
             <Link href={route('courses.index')} style={{ background: '#f1f5f9', color: '#1e293b', padding: '8px 20px', borderRadius: '8px', fontSize: '13px', fontWeight: 700, textDecoration: 'none' }}>
                Resume
            </Link>
        </div>
    </div>
);

export default function AdmissionsIndex({ auth, admissions }) {
    const [activeTab, setActiveTab] = useState('Progress');
    const [search, setSearch] = useState('');
    
    const list = admissions || [];

    return (
        <LmsLayout title="My Courses">
            <Head title="My Courses" />
            
            <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', marginBottom: '32px' }}>
                 <h1 style={{ fontSize: '24px', fontWeight: 800, color: '#1e293b', margin: 0 }}>Courses</h1>
                 <div style={{ display: 'flex', alignItems: 'center', gap: '16px' }}>
                    <div style={{ display: 'flex', background: '#f1f5f9', padding: '4px', borderRadius: '8px' }}>
                        <button style={{ border: 'none', background: 'none', padding: '6px 12px', color: '#64748b' }}><i className="bi bi-list"></i></button>
                        <button style={{ border: 'none', background: '#fff', padding: '6px 12px', color: '#1e293b', borderRadius: '6px', boxShadow: '0 2px 4px rgba(0,0,0,0.05)' }}><i className="bi bi-grid"></i></button>
                    </div>
                    <div style={{ position: 'relative', width: '240px' }}>
                        <i className="bi bi-search" style={{ position: 'absolute', left: '12px', top: '50%', transform: 'translateY(-50%)', color: '#94a3b8' }}></i>
                        <input 
                            type="text" 
                            placeholder="Search" 
                            value={search}
                            onChange={e => setSearch(e.target.value)}
                            style={{ width: '100%', padding: '8px 12px 8px 36px', borderRadius: '8px', border: '1px solid #f1f5f9', outline: 'none', fontSize: '14px' }}
                        />
                    </div>
                 </div>
            </div>

            {/* Tabs */}
            <div style={{ borderBottom: '1px solid #f1f5f9', marginBottom: '24px', display: 'flex', gap: '32px' }}>
                {['Progress', 'Completed'].map(tab => (
                    <button 
                        key={tab} 
                        onClick={() => setActiveTab(tab)}
                        style={{ 
                            padding: '12px 0', border: 'none', background: 'none', fontSize: '15px', fontWeight: 700,
                            color: activeTab === tab ? '#e3000f' : '#64748b',
                            borderBottom: activeTab === tab ? '2px solid #e3000f' : '2px solid transparent',
                            cursor: 'pointer', transition: 'all 0.2s'
                        }}
                    >
                        {tab}
                    </button>
                ))}
            </div>

            <div style={{ maxWidth: '900px' }}>
                {list.length > 0 ? (
                    list.filter(item => activeTab === 'Progress' ? item.status !== 'completed' : item.status === 'completed')
                        .map(item => (
                            <CourseHorizontalCard key={item.id} course={item.course} status={item.status} />
                        ))
                ) : (
                    <div style={{ textAlign: 'center', padding: '64px 0' }}>
                        <i className="bi bi-journal-x" style={{ fontSize: '48px', color: '#cbd5e1', display: 'block', marginBottom: '16px' }}></i>
                        <div style={{ color: '#1e293b', fontWeight: 700, fontSize: '18px' }}>No courses here</div>
                        <p style={{ color: '#64748b', fontSize: '14px' }}>You haven't enrolled in any courses yet.</p>
                        <Link href={route('courses.index')} style={{ color: '#e3000f', fontWeight: 700, textDecoration: 'none' }}>Browse Courses</Link>
                    </div>
                )}
            </div>
        </LmsLayout>
    );
}
