import { useState } from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function LmsLayout({ children }) {
    const { auth } = usePage().props;
    const user = auth?.user;
    const [sidebarOpen, setSidebarOpen] = useState(true);

    const navItems = [
        { label: 'Dashboard', icon: 'bi-speedometer2', href: route('dashboard') },
        { label: 'Courses', icon: 'bi-collection-play', href: route('courses.index') },
        { label: 'My Enrollment', icon: 'bi-journal-check', href: route('enrollments.index') },
        { label: 'Live Classes', icon: 'bi-camera-video', href: route('live-classes.index') },
        { label: 'Study Materials', icon: 'bi-file-earmark-text', href: route('materials.index') },
        { label: 'Fee Management', icon: 'bi-cash-stack', href: route('fees.index') },
        { label: 'Admission', icon: 'bi-person-plus', href: route('admissions.create') },
    ];

    return (
        <div className="lms-wrapper d-flex" style={{ minHeight: '100vh', background: '#0f1117' }}>
            {/* Sidebar */}
            <aside
                className={`lms-sidebar d-flex flex-column ${sidebarOpen ? 'open' : 'collapsed'}`}
                style={{
                    width: sidebarOpen ? '260px' : '72px',
                    minHeight: '100vh',
                    background: 'linear-gradient(160deg, #1a1d2e 0%, #12151f 100%)',
                    borderRight: '1px solid rgba(255,255,255,0.06)',
                    transition: 'width 0.3s ease',
                    position: 'fixed',
                    top: 0,
                    left: 0,
                    zIndex: 1040,
                    overflowX: 'hidden',
                }}
            >
                {/* Logo */}
                <div className="sidebar-logo d-flex align-items-center px-3 py-4" style={{ borderBottom: '1px solid rgba(255,255,255,0.06)', gap: '12px' }}>
                    <div style={{
                        width: '40px', height: '40px', borderRadius: '12px', flexShrink: 0,
                        background: 'linear-gradient(135deg, #7c3aed, #4f46e5)',
                        display: 'flex', alignItems: 'center', justifyContent: 'center',
                    }}>
                        <i className="bi bi-mortarboard-fill" style={{ color: '#fff', fontSize: '18px' }}></i>
                    </div>
                    {sidebarOpen && <span style={{ color: '#fff', fontWeight: 700, fontSize: '18px', whiteSpace: 'nowrap', letterSpacing: '-0.5px' }}>EduLMS</span>}
                </div>

                {/* Nav */}
                <nav className="sidebar-nav flex-grow-1 py-3 px-2">
                    {navItems.map((item) => (
                        <Link
                            key={item.label}
                            href={item.href}
                            className="sidebar-link d-flex align-items-center text-decoration-none mb-1"
                            style={{
                                color: 'rgba(255,255,255,0.65)',
                                padding: '10px 12px',
                                borderRadius: '10px',
                                gap: '12px',
                                transition: 'all 0.2s',
                                whiteSpace: 'nowrap',
                            }}
                        >
                            <i className={`bi ${item.icon}`} style={{ fontSize: '18px', width: '24px', flexShrink: 0, textAlign: 'center' }}></i>
                            {sidebarOpen && <span style={{ fontSize: '14px', fontWeight: 500 }}>{item.label}</span>}
                        </Link>
                    ))}
                </nav>

                {/* User Info */}
                {sidebarOpen && user && (
                    <div className="p-3" style={{ borderTop: '1px solid rgba(255,255,255,0.06)' }}>
                        <div className="d-flex align-items-center gap-2">
                            <div style={{
                                width: '36px', height: '36px', borderRadius: '50%', flexShrink: 0,
                                background: 'linear-gradient(135deg, #7c3aed, #4f46e5)',
                                display: 'flex', alignItems: 'center', justifyContent: 'center',
                                color: '#fff', fontWeight: 700, fontSize: '14px',
                            }}>
                                {user.name?.charAt(0).toUpperCase()}
                            </div>
                            <div style={{ overflow: 'hidden' }}>
                                <div style={{ color: '#fff', fontSize: '13px', fontWeight: 600, overflow: 'hidden', textOverflow: 'ellipsis' }}>{user.name}</div>
                                <div style={{ color: 'rgba(255,255,255,0.45)', fontSize: '11px', overflow: 'hidden', textOverflow: 'ellipsis' }}>{user.email}</div>
                            </div>
                        </div>
                    </div>
                )}
            </aside>

            {/* Main content */}
            <div
                className="lms-main flex-grow-1 d-flex flex-column"
                style={{ marginLeft: sidebarOpen ? '260px' : '72px', transition: 'margin-left 0.3s ease', minHeight: '100vh' }}
            >
                {/* Topbar */}
                <header style={{
                    background: 'rgba(26, 29, 46, 0.85)',
                    backdropFilter: 'blur(12px)',
                    borderBottom: '1px solid rgba(255,255,255,0.06)',
                    padding: '0 24px',
                    height: '64px',
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'space-between',
                    position: 'sticky',
                    top: 0,
                    zIndex: 1030,
                }}>
                    <button
                        onClick={() => setSidebarOpen(!sidebarOpen)}
                        style={{ background: 'transparent', border: 'none', color: 'rgba(255,255,255,0.6)', fontSize: '20px', cursor: 'pointer', padding: '4px' }}
                    >
                        <i className="bi bi-list"></i>
                    </button>

                    <div className="d-flex align-items-center gap-3">
                        {/* Search */}
                        <div style={{ position: 'relative' }}>
                            <i className="bi bi-search" style={{ position: 'absolute', left: '10px', top: '50%', transform: 'translateY(-50%)', color: 'rgba(255,255,255,0.4)', fontSize: '13px' }}></i>
                            <input
                                type="text"
                                placeholder="Search courses..."
                                style={{
                                    background: 'rgba(255,255,255,0.07)',
                                    border: '1px solid rgba(255,255,255,0.1)',
                                    borderRadius: '8px',
                                    color: '#fff',
                                    padding: '7px 12px 7px 30px',
                                    fontSize: '13px',
                                    width: '220px',
                                    outline: 'none',
                                }}
                            />
                        </div>

                        {/* Notification bell */}
                        <button style={{ background: 'rgba(255,255,255,0.07)', border: '1px solid rgba(255,255,255,0.1)', borderRadius: '8px', color: 'rgba(255,255,255,0.6)', padding: '7px 10px', cursor: 'pointer', position: 'relative' }}>
                            <i className="bi bi-bell"></i>
                            <span style={{ position: 'absolute', top: '4px', right: '4px', width: '8px', height: '8px', background: '#7c3aed', borderRadius: '50%', border: '2px solid #1a1d2e' }}></span>
                        </button>

                        {/* Logout */}
                        <Link
                            href={route('logout')}
                            method="post"
                            as="button"
                            style={{ background: 'rgba(255,255,255,0.07)', border: '1px solid rgba(255,255,255,0.1)', borderRadius: '8px', color: 'rgba(255,255,255,0.6)', padding: '7px 12px', cursor: 'pointer', fontSize: '13px' }}
                        >
                            <i className="bi bi-box-arrow-right me-1"></i> Logout
                        </Link>
                    </div>
                </header>

                {/* Page Content */}
                <main className="flex-grow-1 p-4">
                    {children}
                </main>
            </div>
        </div>
    );
}
