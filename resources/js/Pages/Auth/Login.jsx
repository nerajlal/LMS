import { Head, useForm } from '@inertiajs/react';
import { Link } from '@inertiajs/react';

export default function Login({ status, canResetPassword }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('login'), { onFinish: () => reset('password') });
    };

    return (
        <>
            <Head title="Login – EduLMS" />
            <div style={{
                minHeight: '100vh',
                background: '#f3f4f6',
                display: 'flex',
                fontFamily: "'Inter', sans-serif",
            }}>
                {/* Left panel - Blue gradient */}
                <div style={{
                    flex: '1',
                    background: 'linear-gradient(135deg, #3b82f6, #1d4ed8)',
                    display: 'flex',
                    flexDirection: 'column',
                    alignItems: 'center',
                    justifyContent: 'center',
                    padding: '60px 40px',
                    position: 'relative',
                    overflow: 'hidden',
                }}>
                    <div style={{ position: 'absolute', top: '-60px', left: '-60px', width: '250px', height: '250px', border: '2px solid rgba(255,255,255,0.1)', borderRadius: '50%' }}></div>
                    <div style={{ position: 'absolute', bottom: '-40px', right: '-40px', width: '200px', height: '200px', border: '2px solid rgba(255,255,255,0.08)', borderRadius: '50%' }}></div>
                    <div style={{ position: 'relative', textAlign: 'center', color: '#fff' }}>
                        <div style={{ width: '60px', height: '60px', borderRadius: '14px', background: 'rgba(255,255,255,0.2)', display: 'flex', alignItems: 'center', justifyContent: 'center', margin: '0 auto 20px' }}>
                            <i className="bi bi-mortarboard-fill" style={{ fontSize: '28px' }}></i>
                        </div>
                        <h1 style={{ fontSize: '32px', fontWeight: 800, marginBottom: '12px', letterSpacing: '-0.5px' }}>EduLMS</h1>
                        <p style={{ fontSize: '16px', opacity: 0.85, maxWidth: '280px', lineHeight: 1.6 }}>
                            Your complete learning management system. Learn, grow, and achieve.
                        </p>
                        <div style={{ marginTop: '40px', display: 'flex', gap: '24px', justifyContent: 'center' }}>
                            {[
                                { n: '500+', l: 'Courses' },
                                { n: '2K+', l: 'Students' },
                                { n: '50+', l: 'Instructors' },
                            ].map(s => (
                                <div key={s.l} style={{ textAlign: 'center' }}>
                                    <div style={{ fontSize: '22px', fontWeight: 700 }}>{s.n}</div>
                                    <div style={{ fontSize: '12px', opacity: 0.75 }}>{s.l}</div>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>

                {/* Right panel - Login form */}
                <div style={{
                    width: '440px',
                    background: '#fff',
                    display: 'flex',
                    flexDirection: 'column',
                    alignItems: 'center',
                    justifyContent: 'center',
                    padding: '40px 48px',
                }}>
                    <div style={{ width: '100%' }}>
                        <h2 style={{ color: '#1f2937', fontSize: '24px', fontWeight: 700, marginBottom: '6px' }}>Sign in</h2>
                        <p style={{ color: '#6b7280', fontSize: '14px', marginBottom: '28px' }}>
                            Welcome back! Please enter your details.
                        </p>

                        {status && (
                            <div style={{ background: '#d1fae5', border: '1px solid #a7f3d0', borderRadius: '6px', padding: '10px 14px', color: '#065f46', fontSize: '13px', marginBottom: '16px' }}>
                                {status}
                            </div>
                        )}

                        <form onSubmit={submit}>
                            <div style={{ marginBottom: '16px' }}>
                                <label style={{ display: 'block', fontSize: '13px', fontWeight: 500, color: '#374151', marginBottom: '6px' }}>
                                    Email Address
                                </label>
                                <input
                                    type="email"
                                    value={data.email}
                                    onChange={e => setData('email', e.target.value)}
                                    required
                                    autoFocus
                                    placeholder="you@email.com"
                                    style={{
                                        width: '100%', padding: '10px 12px',
                                        border: `1px solid ${errors.email ? '#ef4444' : '#d1d5db'}`,
                                        borderRadius: '6px', fontSize: '14px', color: '#1f2937', outline: 'none',
                                        boxSizing: 'border-box', background: '#fff',
                                    }}
                                    onFocus={e => e.target.style.borderColor = '#3b82f6'}
                                    onBlur={e => e.target.style.borderColor = errors.email ? '#ef4444' : '#d1d5db'}
                                />
                                {errors.email && <p style={{ color: '#ef4444', fontSize: '12px', margin: '4px 0 0' }}>{errors.email}</p>}
                            </div>

                            <div style={{ marginBottom: '20px' }}>
                                <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '6px' }}>
                                    <label style={{ fontSize: '13px', fontWeight: 500, color: '#374151' }}>Password</label>
                                    {canResetPassword && (
                                        <Link href={route('password.request')} style={{ color: '#2563eb', fontSize: '12px', textDecoration: 'none' }}>Forgot password?</Link>
                                    )}
                                </div>
                                <input
                                    type="password"
                                    value={data.password}
                                    onChange={e => setData('password', e.target.value)}
                                    required
                                    placeholder="••••••••"
                                    style={{
                                        width: '100%', padding: '10px 12px',
                                        border: `1px solid ${errors.password ? '#ef4444' : '#d1d5db'}`,
                                        borderRadius: '6px', fontSize: '14px', color: '#1f2937', outline: 'none',
                                        boxSizing: 'border-box', background: '#fff',
                                    }}
                                    onFocus={e => e.target.style.borderColor = '#3b82f6'}
                                    onBlur={e => e.target.style.borderColor = errors.password ? '#ef4444' : '#d1d5db'}
                                />
                                {errors.password && <p style={{ color: '#ef4444', fontSize: '12px', margin: '4px 0 0' }}>{errors.password}</p>}
                            </div>

                            <button
                                type="submit"
                                disabled={processing}
                                style={{
                                    width: '100%', padding: '11px',
                                    background: processing ? '#93c5fd' : '#2563eb',
                                    color: '#fff', border: 'none', borderRadius: '6px',
                                    fontSize: '14px', fontWeight: 600, cursor: processing ? 'not-allowed' : 'pointer',
                                    transition: 'background 0.15s',
                                }}
                                onMouseEnter={e => { if (!processing) e.target.style.background = '#1d4ed8'; }}
                                onMouseLeave={e => { if (!processing) e.target.style.background = '#2563eb'; }}
                            >
                                {processing ? 'Signing in...' : 'Sign In'}
                            </button>
                        </form>

                        <p style={{ textAlign: 'center', color: '#6b7280', fontSize: '13px', marginTop: '20px' }}>
                            Don't have an account?{' '}
                            <Link href={route('register')} style={{ color: '#2563eb', textDecoration: 'none', fontWeight: 600 }}>Apply for Admission</Link>
                        </p>
                    </div>
                </div>
            </div>
        </>
    );
}
