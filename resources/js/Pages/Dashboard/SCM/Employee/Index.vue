<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/Components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import { Badge } from '@/Components/ui/badge';
import StatsCard from '@/Components/dashboard/StatsCard.vue';
import TaskList from '@/Components/dashboard/TaskList.vue';
import InventoryCard from '@/Components/scm/InventoryCard.vue';
import { Package, Truck, CheckCircle, Clock, AlertCircle, ShoppingCart, BarChart } from 'lucide-vue-next';

defineProps({
    stats: {
        type: Object,
        default: () => ({
            assignedTasks: 0,
            pendingOrders: 0,
            completedDeliveries: 0,
            stockAlerts: 0
        })
    },
    tasks: {
        type: Array,
        default: () => []
    },
    inventoryItems: {
        type: Array,
        default: () => []
    },
    pendingOrders: {
        type: Array,
        default: () => []
    }
});
</script>

<template>

    <Head title="SCM Employee Dashboard" />

    <AuthenticatedLayout>
        <div class="p-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold">SCM Employee Dashboard</h1>
                    <p class="text-gray-600">Manage daily supply chain operations</p>
                </div>
                <Badge variant="outline" class="text-sm">
                    Staff Access
                </Badge>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <StatsCard title="Assigned Tasks" :value="stats.assignedTasks" :icon="CheckCircle" color="primary"
                    trend="up" trendValue="+2 today" />
                <StatsCard title="Pending Orders" :value="stats.pendingOrders" :icon="ShoppingCart" color="orange"
                    trend="up" trendValue="+5" />
                <StatsCard title="Completed Deliveries" :value="stats.completedDeliveries" :icon="Truck" color="green"
                    trend="up" trendValue="+8" />
                <StatsCard title="Stock Alerts" :value="stats.stockAlerts" :icon="AlertCircle" color="red" trend="down"
                    trendValue="-3" />
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- My Tasks -->
                    <Card>
                        <CardHeader>
                            <CardTitle class="flex items-center justify-between">
                                <span>My Tasks</span>
                                <Badge variant="secondary">{{ tasks.length }}</Badge>
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <TaskList :tasks="tasks" />
                            <div class="mt-4">
                                <Button variant="outline" as="a" :href="route('scm.employee.tasks')" class="w-full">
                                    View All Tasks
                                </Button>
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Pending Orders -->
                    <Card>
                        <CardHeader>
                            <CardTitle>Pending Orders to Process</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div class="space-y-3">
                                <div v-for="order in pendingOrders.slice(0, 3)" :key="order.id"
                                    class="flex items-center justify-between p-3 border rounded">
                                    <div class="flex items-center space-x-3">
                                        <div class="bg-orange-100 p-2 rounded">
                                            <ShoppingCart class="h-4 w-4 text-orange-600" />
                                        </div>
                                        <div>
                                            <p class="font-medium">Order #{{ order.id }}</p>
                                            <p class="text-sm text-gray-500">{{ order.items }} items</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <Badge variant="outline">{{ order.priority }}</Badge>
                                        <Button size="sm" as="a" :href="route('scm.employee.order.process', order.id)">
                                            Process
                                        </Button>
                                    </div>
                                </div>
                            </div>
                            <Button variant="outline" as="a" :href="route('scm.employee.orders')" class="w-full mt-4">
                                View All Orders
                            </Button>
                        </CardContent>
                    </Card>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Inventory Status -->
                    <Card>
                        <CardHeader>
                            <CardTitle>Inventory Status</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div class="space-y-4">
                                <div v-for="item in inventoryItems.slice(0, 4)" :key="item.id"
                                    class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <Package class="h-4 w-4 text-gray-400" />
                                        <div>
                                            <p class="text-sm font-medium">{{ item.name }}</p>
                                            <p class="text-xs text-gray-500">{{ item.location }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium">{{ item.quantity }} units</p>
                                        <Badge :variant="item.status === 'Low' ? 'destructive' : 'outline'"
                                            class="text-xs">
                                            {{ item.status }}
                                        </Badge>
                                    </div>
                                </div>
                            </div>
                            <Button variant="outline" as="a" :href="route('scm.employee.inventory')"
                                class="w-full mt-4">
                                <Package class="h-4 w-4 mr-2" />
                                View Inventory
                            </Button>
                        </CardContent>
                    </Card>

                    <!-- Quick Actions -->
                    <Card>
                        <CardHeader>
                            <CardTitle>Quick Actions</CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-2">
                            <Button variant="outline" class="w-full justify-start" as="a"
                                :href="route('scm.employee.order.create')">
                                <ShoppingCart class="h-4 w-4 mr-2" />
                                Create Order
                            </Button>
                            <Button variant="outline" class="w-full justify-start" as="a"
                                :href="route('scm.employee.inventory.check')">
                                <Package class="h-4 w-4 mr-2" />
                                Check Stock
                            </Button>
                            <Button variant="outline" class="w-full justify-start" as="a"
                                :href="route('scm.employee.delivery.track')">
                                <Truck class="h-4 w-4 mr-2" />
                                Track Delivery
                            </Button>
                            <Button variant="outline" class="w-full justify-start" as="a"
                                :href="route('scm.employee.quality.check')">
                                <CheckCircle class="h-4 w-4 mr-2" />
                                Quality Check
                            </Button>
                        </CardContent>
                    </Card>

                    <!-- Performance Metrics -->
                    <Card>
                        <CardHeader>
                            <CardTitle>My Performance</CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Tasks Completed</span>
                                <span class="font-bold">{{ stats.completedDeliveries }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Accuracy Rate</span>
                                <span class="font-bold text-green-600">98%</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">On-time Delivery</span>
                                <span class="font-bold text-green-600">95%</span>
                            </div>
                            <Button variant="ghost" class="w-full" as="a" :href="route('scm.employee.performance')">
                                View Details
                            </Button>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>