<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/Components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import { Badge } from '@/Components/ui/badge';
import StatsCard from '@/Components/dashboard/StatsCard.vue';
import TaskList from '@/Components/dashboard/TaskList.vue';
import RecentActivity from '@/Components/dashboard/RecentActivity.vue';
import { CheckCircle, Clock, Calendar, FileText, Users, AlertCircle } from 'lucide-vue-next';

defineProps({
    stats: {
        type: Object,
        default: () => ({
            myTasks: 0,
            pendingApprovals: 0,
            upcomingInterviews: 0,
            completedThisWeek: 0
        })
    },
    tasks: {
        type: Array,
        default: () => []
    },
    recentActivities: {
        type: Array,
        default: () => []
    },
    upcomingEvents: {
        type: Array,
        default: () => []
    }
});
</script>

<template>

    <Head title="HRM Employee Dashboard" />

    <AuthenticatedLayout>
        <div class="p-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold">HRM Employee Dashboard</h1>
                    <p class="text-gray-600">Welcome to your HR workspace</p>
                </div>
                <Badge variant="outline" class="text-sm">
                    Staff Access
                </Badge>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <StatsCard title="My Tasks" :value="stats.myTasks" :icon="FileText" color="primary" trend="up"
                    trendValue="+3 today" />
                <StatsCard title="Pending Approvals" :value="stats.pendingApprovals" :icon="Clock" color="orange"
                    trend="neutral" />
                <StatsCard title="Upcoming Interviews" :value="stats.upcomingInterviews" :icon="Users" color="blue"
                    trend="down" trendValue="-2" />
                <StatsCard title="Completed This Week" :value="stats.completedThisWeek" :icon="CheckCircle"
                    color="green" trend="up" trendValue="+5" />
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Today's Tasks -->
                    <Card>
                        <CardHeader>
                            <CardTitle class="flex items-center justify-between">
                                <span>Today's Tasks</span>
                                <Badge variant="secondary">{{ tasks.length }}</Badge>
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <TaskList :tasks="tasks" />
                            <div class="mt-4">
                                <Button variant="outline" as="a" :href="route('hrm.employee.tasks')" class="w-full">
                                    View All Tasks
                                </Button>
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Quick Actions -->
                    <Card>
                        <CardHeader>
                            <CardTitle>Quick Actions</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div class="grid grid-cols-2 gap-4">
                                <Button variant="outline" as="a" :href="route('hrm.employee.attendance.log')">
                                    <Clock class="h-4 w-4 mr-2" />
                                    Log Attendance
                                </Button>
                                <Button variant="outline" as="a" :href="route('hrm.employee.leave.request')">
                                    <Calendar class="h-4 w-4 mr-2" />
                                    Request Leave
                                </Button>
                                <Button variant="outline" as="a" :href="route('hrm.employee.tasks.create')">
                                    <FileText class="h-4 w-4 mr-2" />
                                    New Task
                                </Button>
                                <Button variant="outline" as="a" :href="route('hrm.employee.reports')">
                                    <BarChart class="h-4 w-4 mr-2" />
                                    My Reports
                                </Button>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Recent Activity -->
                    <Card>
                        <CardHeader>
                            <CardTitle>Recent Activity</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <RecentActivity :activities="recentActivities" />
                        </CardContent>
                    </Card>

                    <!-- Upcoming Events -->
                    <Card>
                        <CardHeader>
                            <CardTitle>Upcoming Events</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div class="space-y-4">
                                <div v-for="event in upcomingEvents" :key="event.id" class="flex items-start space-x-3">
                                    <div class="bg-blue-100 p-2 rounded">
                                        <Calendar class="h-4 w-4 text-blue-600" />
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-medium text-sm">{{ event.title }}</p>
                                        <p class="text-xs text-gray-500">{{ event.time }}</p>
                                    </div>
                                    <Badge variant="outline" class="text-xs">
                                        {{ event.type }}
                                    </Badge>
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Quick Links -->
                    <Card>
                        <CardHeader>
                            <CardTitle>Quick Links</CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-2">
                            <Button variant="ghost" class="w-full justify-start" as="a"
                                :href="route('hrm.employee.profile')">
                                <User class="h-4 w-4 mr-2" />
                                My Profile
                            </Button>
                            <Button variant="ghost" class="w-full justify-start" as="a"
                                :href="route('hrm.employee.documents')">
                                <Folder class="h-4 w-4 mr-2" />
                                My Documents
                            </Button>
                            <Button variant="ghost" class="w-full justify-start" as="a"
                                :href="route('hrm.employee.schedule')">
                                <Calendar class="h-4 w-4 mr-2" />
                                My Schedule
                            </Button>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>