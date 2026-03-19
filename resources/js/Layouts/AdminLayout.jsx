import { useState } from 'react';
import { Link, usePage } from '@inertiajs/react';

const ADMIN_NAV = [
    { label: 'Dashboard',   icon: 'bi-speedometer2',      href: 'admin.dashboard' },
    { label: 'Courses',     icon: 'bi-collection-play',   href: 'admin.courses.index' },
    { label: 'Live Classes', icon: 'bi-camera-video',     href: 'admin.live-classes.index' },
    { label: 'Resources',   icon: 'bi-file-earmark-text', href: 'admin.study-materials.index' },
    { label: 'Students',    icon: 'bi-people',             href: 'admin.students.index' },
    { label: 'Admissions',  icon: 'bi-person-check',       href: 'admin.admissions.index' },
    { label: 'Fees',        icon: 'bi-cash-stack',         href: 'admin.fees.index' },
];

export default function AdminLayout({ children, title }) {
    const { auth } = usePage().props;
    const user = auth?.user;
    const [sidebarOpen, setSidebarOpen] = useState(true);

    // Active detection
    const currentPath = typeof window !== 'undefined' ? window.location.pathname : '';

    return (
        <div style={{ display: 'flex', minHeight: '100vh', background: '#f3f4f6', fontFamily: "'Inter', sans-serif" }}>

            {/* ── SIDEBAR ── */}
            <aside style={{
                width: sidebarOpen ? '240px' : '64px',
                minHeight: '100vh',
                background: '#1e1b4b',
                display: 'flex',
                flexDirection: 'column',
                position: 'fixed',
                top: 0, left: 0,
                zIndex: 1040,
                transition: 'width 0.25s ease',
                overflowX: 'hidden',
                boxShadow: '2px 0 12px rgba(0,0,0,0.15)',
            }}>
                {/* Logo */}
                <div style={{
                    height: '64px', display: 'flex', alignItems: 'center',
                    padding: '0 16px', borderBottom: '1px solid rgba(255,255,255,0.08)',
                    gap: '10px', flexShrink: 0,
                }}>
                    <div style={{
                        width: '36px', height: '36px', borderRadius: '8px',
                        background: 'linear-gradient(135deg, #7c3aed, #4f46e5)',
                        display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0,
                    }}>
                        <i className="bi bi-shield-check" style={{ color: '#fff', fontSize: '16px' }}></i>
                    </div>
                    {sidebarOpen && (
                        <div>
                            <div style={{ fontWeight: 700, fontSize: '15px', color: '#fff', whiteSpace: 'nowrap' }}>EduLMS Admin</div>
                            <div style={{ fontSize: '10px', color: 'rgba(255,255,255,0.4)', whiteSpace: 'nowrap' }}>Management Panel</div>
                        </div>
                    )}
                </div>

                {/* Navigation */}
                <nav style={{ flex: 1, padding: '12px 8px', overflowY: 'auto' }}>
                    {ADMIN_NAV.map(item => {
                        const active = currentPath.startsWith('/admin/' + item.href.replace('admin.', '').replace('.index', '').replace('.', '/'))
                            || (item.href === 'admin.dashboard' && currentPath === '/admin');
                        return (
                            <Link
                                key={item.label}
                                href={route(item.href)}
                                style={{
                                    display: 'flex', alignItems: 'center', gap: '10px',
                                    padding: '9px 12px', borderRadius: '6px', marginBottom: '2px',
                                    color: active ? '#fff' : 'rgba(255,255,255,0.55)',
                                    background: active ? 'rgba(124,58,237,0.4)' : 'transparent',
                                    textDecoration: 'none', fontWeight: active ? 600 : 400,
                                    fontSize: '14px', whiteSpace: 'nowrap', transition: 'all 0.15s',
                                    borderLeft: active ? '3px solid #7c3aed' : '3px solid transparent',
                                }}
                                onMouseEnter={e => { if (!active) { e.currentTarget.style.background = 'rgba(255,255,255,0.08)'; e.currentTarget.style.color = '#fff'; }}}
                                onMouseLeave={e => { if (!active) { e.currentTarget.style.background = 'transparent'; e.currentTarget.style.color = 'rgba(255,255,255,0.55)'; }}}
                            >
                                <i className={`bi ${item.icon}`} style={{ fontSize: '17px', width: '20px', textAlign: 'center', flexShrink: 0 }}></i>
                                {sidebarOpen && <span>{item.label}</span>}
                            </Link>
                        );
                    })}

                    {/* Divider + Student view link */}
                    {sidebarOpen && (
                        <div style={{ borderTop: '1px solid rgba(255,255,255,0.08)', margin: '12px 4px', paddingTop: '12px' }}>
                            <Link href={route('dashboard')} style={{
                                display: 'flex', alignItems: 'center', gap: '10px',
                                padding: '9px 12px', borderRadius: '6px',
                                color: 'rgba(255,255,255,0.4)', textDecoration: 'none', fontSize: '13px',
                            }}>
                                <i className="bi bi-box-arrow-left" style={{ fontSize: '15px' }}></i>
                                <span>Student View</span>
                            </Link>
                        </div>
                    )}
                </nav>

                {/* User footer */}
                {sidebarOpen && user && (
                    <div style={{ padding: '12px 16px', borderTop: '1px solid rgba(255,255,255,0.08)', display: 'flex', alignItems: 'center', gap: '10px' }}>
                        <div style={{
                            width: '34px', height: '34px', borderRadius: '50%', flexShrink: 0,
                            background: 'linear-gradient(135deg, #7c3aed, #4f46e5)',
                            display: 'flex', alignItems: 'center', justifyContent: 'center',
                            color: '#fff', fontWeight: 700, fontSize: '13px',
                        }}>
                            {user.name?.charAt(0).toUpperCase()}
                        </div>
                        <div style={{ overflow: 'hidden' }}>
                            <div style={{ fontSize: '13px', fontWeight: 600, color: '#fff', overflow: 'hidden', textOverflow: 'ellipsis', whiteSpace: 'nowrap' }}>{user.name}</div>
                            <div style={{ fontSize: '11px', color: 'rgba(255,255,255,0.4)' }}>Administrator</div>
                        </div>
                    </div>
                )}
            </aside>

            {/* ── MAIN ── */}
            <div style={{ marginLeft: sidebarOpen ? '240px' : '64px', flex: 1, display: 'flex', flexDirection: 'column', transition: 'margin-left 0.25s ease', minHeight: '100vh' }}>

                {/* Header */}
                <header style={{
                    background: 'linear-gradient(to right, #7c3aed, #4f46e5)',
                    height: '64px', display: 'flex', alignItems: 'center',
                    justifyContent: 'space-between', padding: '0 24px',
                    position: 'sticky', top: 0, zIndex: 1030,
                    boxShadow: '0 2px 8px rgba(124,58,237,0.3)',
                }}>
                    <div style={{ display: 'flex', alignItems: 'center', gap: '14px' }}>
                        <button
                            onClick={() => setSidebarOpen(!sidebarOpen)}
                            style={{ background: 'rgba(255,255,255,0.15)', border: 'none', borderRadius: '6px', color: '#fff', fontSize: '18px', cursor: 'pointer', padding: '5px 8px' }}
                        >
                            <i className="bi bi-list"></i>
                        </button>
                        {title && <h1 style={{ color: '#fff', fontSize: '17px', fontWeight: 600, margin: 0 }}>{title}</h1>}
                    </div>

                    <div style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
                        <span style={{ color: 'rgba(255,255,255,0.7)', fontSize: '13px' }}>
                            <i className="bi bi-shield-check me-1"></i> Admin Panel
                        </span>
                        <Link
                            href={route('logout')} method="post" as="button"
                            style={{ background: 'rgba(255,255,255,0.15)', border: '1px solid rgba(255,255,255,0.25)', borderRadius: '6px', color: '#fff', padding: '7px 12px', cursor: 'pointer', fontSize: '13px', fontWeight: 500 }}
                        >
                            <i className="bi bi-box-arrow-right me-1"></i> Logout
                        </Link>
                    </div>
                </header>

                {/* Page Content */}
                <main style={{ flex: 1, padding: '28px 24px', background: '#f3f4f6' }}>
                    {children}
                </main>
            </div>
        </div>
    );
}
